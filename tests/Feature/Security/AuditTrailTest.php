<?php

namespace Tests\Feature\Security;

use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    private function createPemohonUser(): User
    {
        return User::factory()->create([
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    private function createStaffUser(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }

    private function createPermohonanWithDokumen(User $pemohon): array
    {
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-AUDIT-001',
            'status' => 'menunggu_verifikasi',
        ]);

        Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Pewasiat Audit',
            'nik' => '3578011111110001',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1960-01-01',
            'tempat_tinggal_terakhir' => 'Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2025-01-01',
            'nomor_akta_kematian' => 'KM-01',
            'tanggal_akta_kematian' => '2025-01-02',
            'pejabat_pembuat_akta_kematian' => 'Disdukcapil Surabaya',
            'nomor_surat_dpw' => 'DPW-01',
            'tanggal_surat_dpw' => '2025-01-05',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-01',
            'tanggal_akta_penyimpanan' => '2020-01-01',
            'nama_notaris' => 'Notaris Audit',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'tidak_kawin',
        ]);

        $fakeFile = UploadedFile::fake()->create('akta_kematian.pdf', 50, 'application/pdf');
        $storedPath = $fakeFile->store("dokumens/{$permohonan->id}", 'local');

        $dokumen = Dokumen::create([
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'akta_kematian',
            'file_path' => $storedPath,
            'status' => 'diunggah',
        ]);

        return [$permohonan, $dokumen];
    }

    public function test_viewing_secure_document_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $petugas = $this->createStaffUser('petugas');
        [$permohonan, $dokumen] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($petugas)->get(route('secure.dokumen.show', $dokumen->id));

        $response->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'view_dokumen',
            'user_id' => $petugas->id,
            'permohonan_id' => $permohonan->id,
            'resource_type' => 'dokumen',
            'resource_id' => $dokumen->id,
        ]);
    }

    public function test_downloading_secure_document_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        [$permohonan, $dokumen] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($pemohon)->get(route('secure.dokumen.download', $dokumen->id));

        $response->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'download_dokumen',
            'user_id' => $pemohon->id,
            'permohonan_id' => $permohonan->id,
            'resource_type' => 'dokumen',
            'resource_id' => $dokumen->id,
        ]);
    }

    public function test_viewing_voucher_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $bendahara = $this->createStaffUser('bendahara');

        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-AUDIT-002',
            'status' => 'menunggu_voucher',
        ]);

        $fakeVoucher = UploadedFile::fake()->create('voucher.pdf', 30, 'application/pdf');
        $voucherPath = $fakeVoucher->store("vouchers/{$permohonan->id}", 'local');

        $voucher = Voucher::create([
            'permohonan_id' => $permohonan->id,
            'nomor_voucher' => 'VCH-AUDIT-001',
            'nominal' => 200000,
            'file_voucher' => $voucherPath,
            'status_pembayaran' => 'lunas',
        ]);

        $response = $this->actingAs($bendahara)->get(route('secure.voucher.show', $voucher->id));

        $response->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'view_voucher',
            'user_id' => $bendahara->id,
            'permohonan_id' => $permohonan->id,
            'resource_type' => 'voucher',
            'resource_id' => $voucher->id,
        ]);
    }

    public function test_petugas_verifikasi_action_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $petugas = $this->createStaffUser('petugas');
        [$permohonan] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($petugas)->post(route('petugas.tindak-lanjut', $permohonan->id), [
            'status' => 'disetujui',
            'catatan' => 'Berkas absah dan lengkap.',
        ]);

        $response->assertRedirect(route('petugas.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'verifikasi_pertama',
            'user_id' => $petugas->id,
            'permohonan_id' => $permohonan->id,
        ]);
    }

    public function test_kasi_disposisi_action_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $kasi = $this->createStaffUser('kasi');
        [$permohonan] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($kasi)->post(route('kasi.disposisi', $permohonan->id), [
            'pic' => ['Kurator Muda Lutfy, S.H.'],
            'prioritas' => 'biasa',
            'catatan' => 'Mohon ditelaah.',
        ]);

        $response->assertRedirect(route('kasi.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'disposisi_kasi',
            'user_id' => $kasi->id,
            'permohonan_id' => $permohonan->id,
        ]);
    }

    public function test_muda_jadwal_action_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $muda = $this->createStaffUser('kurator_muda');
        [$permohonan] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($muda)->post(route('muda.jadwal.tindak-lanjut', $permohonan->id), [
            'status' => 'disetujui',
            'jadwal_tanggal' => now()->addDays(5)->format('Y-m-d'),
            'jadwal_waktu' => '10:00',
            'lokasi' => 'Ruang Sidang BHP Surabaya',
        ]);

        $response->assertRedirect(route('muda.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'jadwal_muda',
            'user_id' => $muda->id,
            'permohonan_id' => $permohonan->id,
        ]);
    }

    public function test_madya_buat_ba_action_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $madya = $this->createStaffUser('kurator_madya');
        [$permohonan] = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($madya)->post(route('madya.layanan.buat-ba', $permohonan->id), [
            'nomor_ba' => 'BA.01/WST/BHP.SBY/2026',
            'catatan' => 'BA telah terbit.',
        ]);

        $response->assertRedirect(route('madya.dashboard'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'buat_ba_madya',
            'user_id' => $madya->id,
            'permohonan_id' => $permohonan->id,
        ]);
    }

    public function test_bendahara_pnbp_action_creates_audit_log(): void
    {
        $pemohon = $this->createPemohonUser();
        $bendahara = $this->createStaffUser('bendahara');

        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-AUDIT-003',
            'status' => 'menunggu_voucher',
        ]);

        $fakeVoucher = UploadedFile::fake()->create('bukti_bayar.pdf', 30, 'application/pdf');

        $response = $this->actingAs($bendahara)->post(route('bendahara.verifikasi.tindak-lanjut', $permohonan->id), [
            'ntpn' => 'NTPN12345678',
            'nominal' => 200000,
            'tanggal_bayar' => '2026-03-01',
            'file_voucher' => $fakeVoucher,
        ]);

        $response->assertRedirect(route('bendahara.verifikasi.index'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'verifikasi_pnbp',
            'user_id' => $bendahara->id,
            'permohonan_id' => $permohonan->id,
        ]);
    }
}
