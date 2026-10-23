<?php

namespace Tests\Feature;

use App\Http\Controllers\Bendahara\BendaharaPnbpController;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BendaharaPnbpTest extends TestCase
{
    use RefreshDatabase;

    private function createBendaharaUser(): User
    {
        return User::factory()->create([
            'name' => 'Bendahara Penerimaan BHP',
            'email' => 'bendahara@pandubhp.go.id',
            'role' => 'bendahara',
            'pekerjaan' => 'Bendahara Penerimaan',
            'status_akun' => 'bendahara',
            'status_verifikasi' => 'terverifikasi',
            'email_verified_at' => now(),
        ]);
    }

    private function createPemohonUser(): User
    {
        return User::factory()->create([
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    public function test_unauthenticated_user_redirected_to_login(): void
    {
        $response = $this->get(route('bendahara.verifikasi.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_bendahara_pnbp(): void
    {
        $pemohon = $this->createPemohonUser();

        $response = $this->actingAs($pemohon)->get(route('bendahara.verifikasi.index'));

        $response->assertForbidden();
    }

    public function test_bendahara_is_redirected_to_verifikasi_pnbp_from_root_dashboard(): void
    {
        $bendahara = $this->createBendaharaUser();

        $response = $this->actingAs($bendahara)->get(route('dashboard'));

        $response->assertRedirect(route('bendahara.verifikasi.index'));
    }

    public function test_bendahara_can_view_verifikasi_pnbp_page(): void
    {
        $bendahara = $this->createBendaharaUser();

        $response = $this->actingAs($bendahara)->get(route('bendahara.verifikasi.index'));

        $response->assertOk();
        $response->assertSee('Verifikasi PNBP &amp; SLA Layanan', false);
        $response->assertSee('Daftar Antrean Verifikasi PNBP');
        $response->assertSee('Sudah Bayar');
        $response->assertSee('Belum Bayar');
    }

    public function test_bendahara_can_filter_verifikasi_pnbp_by_status(): void
    {
        $bendahara = $this->createBendaharaUser();

        $responseSudah = $this->actingAs($bendahara)->get(route('bendahara.verifikasi.index', ['status' => 'sudah_bayar']));
        $responseSudah->assertOk();

        $responseBelum = $this->actingAs($bendahara)->get(route('bendahara.verifikasi.index', ['status' => 'belum_bayar']));
        $responseBelum->assertOk();

        $responseKadaluarsa = $this->actingAs($bendahara)->get(route('bendahara.verifikasi.index', ['status' => 'kadaluarsa']));
        $responseKadaluarsa->assertOk();
    }

    private function createPewasiat(int $permohonanId, string $nama = 'Pewasiat Contoh'): Pewasiat
    {
        return Pewasiat::create([
            'permohonan_id' => $permohonanId,
            'nama_lengkap' => $nama,
            'nik' => '3578012345678901',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1960-01-01',
            'tempat_tinggal_terakhir' => 'Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2026-01-01',
            'nomor_akta_kematian' => 'AK-01',
            'tanggal_akta_kematian' => '2026-01-02',
            'pejabat_pembuat_akta_kematian' => 'Surabaya',
            'nomor_surat_dpw' => 'DPW-01',
            'tanggal_surat_dpw' => '2026-01-03',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-01',
            'tanggal_akta_penyimpanan' => '2020-01-01',
            'nama_notaris' => 'Notaris A',
            'kedudukan_notaris' => 'Surabaya',
            'status_kawin' => 'tidak_kawin',
        ]);
    }

    public function test_bendahara_can_submit_tindak_lanjut_with_ntpn_and_voucher(): void
    {
        Storage::fake('public');

        $bendahara = $this->createBendaharaUser();
        $pemohon = $this->createPemohonUser();

        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'W15.AHU.AHU.1.AH.06.01-00099',
            'status' => 'menunggu_verifikasi',
        ]);

        $this->createPewasiat($permohonan->id, 'Alm. Uji Coba Testing');

        $voucher = Voucher::create([
            'permohonan_id' => $permohonan->id,
            'nomor_voucher' => 'VCH-TEST-00099',
            'status_pembayaran' => 'belum_bayar',
            'nominal' => 200000,
        ]);

        $file = UploadedFile::fake()->create('bukti_voucher.pdf', 500, 'application/pdf');

        $payload = [
            'ntpn' => '261023B999888777',
            'nominal' => 200000,
            'tanggal_bayar' => '2026-10-23',
            'file_voucher' => $file,
            'catatan' => 'Verifikasi PNBP sukses melalui Simponi BNI.',
        ];

        $response = $this->actingAs($bendahara)
            ->post(route('bendahara.verifikasi.tindak-lanjut', 'db_'.$permohonan->id), $payload);

        $response->assertRedirect(route('bendahara.verifikasi.index'));
        $response->assertSessionHas('success');

        $voucher->refresh();
        $this->assertSame('lunas', $voucher->status_pembayaran);
        $this->assertSame('261023B999888777', $voucher->ntpn);
        $this->assertSame(200000, $voucher->nominal);
        $this->assertNotNull($voucher->file_voucher);
    }

    public function test_bendahara_can_view_history_page(): void
    {
        $bendahara = $this->createBendaharaUser();

        $response = $this->actingAs($bendahara)->get(route('bendahara.history.index'));

        $response->assertOk();
        $response->assertSee('Riwayat Verifikasi PNBP');
        $response->assertSee('Total Penerimaan PNBP');
    }

    public function test_bendahara_can_export_history_to_csv(): void
    {
        $bendahara = $this->createBendaharaUser();

        $response = $this->actingAs($bendahara)->get(route('bendahara.history.export'));

        $response->assertOk();
        $this->assertStringContainsString('text/csv', (string) $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment; filename=', (string) $response->headers->get('content-disposition'));
    }

    public function test_get_pending_count_returns_belum_bayar_count(): void
    {
        session()->forget('bendahara_pnbp_list');

        $count = BendaharaPnbpController::getPendingCount();

        // In default list, there are 3 items with status_pnbp = 'belum_bayar'
        $this->assertGreaterThanOrEqual(3, $count);
    }
}
