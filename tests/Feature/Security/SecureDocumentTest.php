<?php

namespace Tests\Feature\Security;

use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecureDocumentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');
    }

    private function createPemohonUser(string $name = 'Pemohon Test'): User
    {
        return User::factory()->create([
            'name' => $name,
            'role' => 'pemohon',
            'email_verified_at' => now(),
        ]);
    }

    private function createBhpStaff(string $role = 'petugas'): User
    {
        return User::factory()->create([
            'role' => $role,
            'email_verified_at' => now(),
        ]);
    }

    private function createPermohonanWithDokumen(User $pemohon): Dokumen
    {
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-TEST-001',
            'status' => 'menunggu_verifikasi',
        ]);

        $fakeFile = UploadedFile::fake()->create('akta_kematian.pdf', 100, 'application/pdf');
        $storedPath = $fakeFile->store("dokumens/{$permohonan->id}", 'local');

        return Dokumen::create([
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'akta_kematian',
            'file_path' => $storedPath,
            'status' => 'diunggah',
        ]);
    }

    public function test_guest_cannot_access_secure_dokumen(): void
    {
        $pemohon = $this->createPemohonUser();
        $dokumen = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->get(route('secure.dokumen.show', $dokumen->id));

        $response->assertRedirect(route('login'));
    }

    public function test_pemohon_cannot_access_another_pemohon_dokumen(): void
    {
        $pemohonA = $this->createPemohonUser('Pemohon A');
        $pemohonB = $this->createPemohonUser('Pemohon B');

        $dokumenA = $this->createPermohonanWithDokumen($pemohonA);

        // Pemohon B mencoba melihat dokumen milik Pemohon A
        $response = $this->actingAs($pemohonB)->get(route('secure.dokumen.show', $dokumenA->id));

        $response->assertForbidden();
    }

    public function test_pemohon_can_access_their_own_dokumen(): void
    {
        $pemohon = $this->createPemohonUser();
        $dokumen = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($pemohon)->get(route('secure.dokumen.show', $dokumen->id));

        $response->assertOk();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertStringContainsString('no-cache', (string) $response->headers->get('Cache-Control'));
    }

    public function test_kurator_and_bhp_staff_can_access_any_dokumen(): void
    {
        $pemohon = $this->createPemohonUser();
        $dokumen = $this->createPermohonanWithDokumen($pemohon);

        $roles = ['petugas', 'jfkk_pertama', 'jfkk_muda', 'jfkk_madya', 'kasi', 'bendahara', 'master_admin'];

        foreach ($roles as $role) {
            $staff = $this->createBhpStaff($role);

            $response = $this->actingAs($staff)->get(route('secure.dokumen.show', $dokumen->id));
            $response->assertOk();
        }
    }

    public function test_pemohon_can_download_their_own_dokumen(): void
    {
        $pemohon = $this->createPemohonUser();
        $dokumen = $this->createPermohonanWithDokumen($pemohon);

        $response = $this->actingAs($pemohon)->get(route('secure.dokumen.download', $dokumen->id));

        $response->assertOk();
        $response->assertHeader('Content-Disposition', 'attachment; filename='.basename($dokumen->file_path));
    }

    public function test_unauthorized_user_cannot_access_voucher(): void
    {
        $pemohonA = $this->createPemohonUser('Pemohon A');
        $pemohonB = $this->createPemohonUser('Pemohon B');

        $permohonanA = Permohonan::create([
            'user_id' => $pemohonA->id,
            'nomor_permohonan' => 'WST-TEST-002',
            'status' => 'menunggu_voucher',
        ]);

        $fakeVoucher = UploadedFile::fake()->create('voucher.pdf', 50, 'application/pdf');
        $voucherPath = $fakeVoucher->store("vouchers/{$permohonanA->id}", 'local');

        $voucher = Voucher::create([
            'permohonan_id' => $permohonanA->id,
            'nomor_voucher' => 'VCH-TEST-001',
            'nominal' => 200000,
            'file_voucher' => $voucherPath,
            'status_pembayaran' => 'lunas',
        ]);

        // Pemohon B dilarang melihat voucher Pemohon A
        $response = $this->actingAs($pemohonB)->get(route('secure.voucher.show', $voucher->id));
        $response->assertForbidden();

        // Pemohon A boleh melihat vouchernya sendiri
        $responseOwner = $this->actingAs($pemohonA)->get(route('secure.voucher.show', $voucher->id));
        $responseOwner->assertOk();

        // Bendahara boleh melihat voucher
        $bendahara = $this->createBhpStaff('bendahara');
        $responseBendahara = $this->actingAs($bendahara)->get(route('secure.voucher.show', $voucher->id));
        $responseBendahara->assertOk();
    }

    public function test_user_dokumen_can_only_be_accessed_by_owner_or_admin(): void
    {
        $userA = $this->createPemohonUser('Notaris A');
        $fakeSk = UploadedFile::fake()->create('sk_notaris.pdf', 100, 'application/pdf');
        $skPath = $fakeSk->store('sk_notaris', 'local');
        $userA->update(['sk_notaris' => $skPath]);

        $userB = $this->createPemohonUser('User B');
        $admin = $this->createBhpStaff('master_admin');

        // User B dilarang membuka SK Notaris User A
        $this->actingAs($userB)
            ->get(route('secure.user-dokumen.show', [$userA->id, 'sk_notaris']))
            ->assertForbidden();

        // User A membuka berkasnya sendiri -> OK
        $this->actingAs($userA)
            ->get(route('secure.user-dokumen.show', [$userA->id, 'sk_notaris']))
            ->assertOk();

        // Admin membuka berkas User A -> OK
        $this->actingAs($admin)
            ->get(route('secure.user-dokumen.show', [$userA->id, 'sk_notaris']))
            ->assertOk();
    }

    public function test_returns_404_when_file_not_found_on_disk(): void
    {
        $pemohon = $this->createPemohonUser();
        $permohonan = Permohonan::create([
            'user_id' => $pemohon->id,
            'nomor_permohonan' => 'WST-TEST-404',
            'status' => 'menunggu_verifikasi',
        ]);

        $dokumen = Dokumen::create([
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'surat_kuasa',
            'file_path' => 'dokumens/999/non_existent.pdf',
            'status' => 'diunggah',
        ]);

        $response = $this->actingAs($pemohon)->get(route('secure.dokumen.show', $dokumen->id));

        $response->assertNotFound();
    }
}
