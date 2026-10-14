<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserVerificationTest extends TestCase
{
    use RefreshDatabase;

    private function createMasterAdmin(): User
    {
        return User::factory()->create([
            'role' => 'master_admin',
            'status_akun' => 'master_admin',
            'status_verifikasi' => 'terverifikasi',
        ]);
    }

    private function createPemohonNotarisPending(): User
    {
        return User::factory()->create([
            'role' => 'pemohon',
            'pekerjaan' => 'Notaris',
            'jenis_akun' => 'notaris',
            'status_akun' => 'perorangan',
            'status_verifikasi' => 'menunggu_verifikasi',
            'sk_notaris' => 'sk_notaris/sample.pdf',
            'sk_ppat' => 'sk_ppat/sample.pdf',
        ]);
    }

    private function createPemohonPengacaraPending(): User
    {
        return User::factory()->create([
            'role' => 'pemohon',
            'pekerjaan' => 'Pengacara',
            'jenis_akun' => 'pengacara',
            'status_akun' => 'perorangan',
            'status_verifikasi' => 'menunggu_verifikasi',
            'berita_acara_sumpah' => 'berita_acara_sumpah/sample.pdf',
            'id_card_pengacara' => 'id_card_pengacara/sample.jpg',
        ]);
    }

    public function test_guest_cannot_access_verification_page(): void
    {
        $response = $this->get(route('admin.verifikasi.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_regular_pemohon_cannot_access_verification_page(): void
    {
        $pemohon = User::factory()->create(['role' => 'pemohon']);

        $response = $this->actingAs($pemohon)->get(route('admin.verifikasi.index'));

        $response->assertForbidden();
    }

    public function test_petugas_cannot_access_verification_page(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);

        $response = $this->actingAs($petugas)->get(route('admin.verifikasi.index'));

        $response->assertForbidden();
    }

    public function test_master_admin_can_view_verification_index_and_pending_users(): void
    {
        $admin = $this->createMasterAdmin();
        $notaris = $this->createPemohonNotarisPending();

        $response = $this->actingAs($admin)->get(route('admin.verifikasi.index'));

        $response->assertOk();
        $response->assertSee($notaris->name);
        $response->assertSee('Menunggu Verifikasi');
    }

    public function test_master_admin_can_view_verification_detail(): void
    {
        $admin = $this->createMasterAdmin();
        $notaris = $this->createPemohonNotarisPending();

        $response = $this->actingAs($admin)->get(route('admin.verifikasi.show', $notaris));

        $response->assertOk();
        $response->assertSee($notaris->name);
        $response->assertSee('SK Notaris');
        $response->assertSee('SK PPAT');
    }

    public function test_master_admin_can_approve_notaris_account(): void
    {
        $admin = $this->createMasterAdmin();
        $notaris = $this->createPemohonNotarisPending();

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.approve', $notaris), [
            'catatan_verifikasi' => 'Dokumen valid dan disetujui.',
        ]);

        $response->assertRedirect(route('admin.verifikasi.index'));
        $response->assertSessionHas('status');

        $notaris->refresh();
        $this->assertSame('notaris', $notaris->status_akun);
        $this->assertSame('terverifikasi', $notaris->status_verifikasi);
        $this->assertNotNull($notaris->verified_at);
    }

    public function test_master_admin_can_approve_pengacara_account(): void
    {
        $admin = $this->createMasterAdmin();
        $pengacara = $this->createPemohonPengacaraPending();

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.approve', $pengacara));

        $response->assertRedirect(route('admin.verifikasi.index'));

        $pengacara->refresh();
        $this->assertSame('pengacara', $pengacara->status_akun);
        $this->assertSame('terverifikasi', $pengacara->status_verifikasi);
        $this->assertNotNull($pengacara->verified_at);
    }

    public function test_master_admin_can_reject_verification_with_notes(): void
    {
        $admin = $this->createMasterAdmin();
        $notaris = $this->createPemohonNotarisPending();

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.reject', $notaris), [
            'catatan_verifikasi' => 'File SK Notaris buram dan tidak dapat dibaca.',
        ]);

        $response->assertRedirect(route('admin.verifikasi.index'));

        $notaris->refresh();
        $this->assertSame('perorangan', $notaris->status_akun);
        $this->assertSame('ditolak', $notaris->status_verifikasi);
        $this->assertSame('File SK Notaris buram dan tidak dapat dibaca.', $notaris->catatan_verifikasi);
    }

    public function test_master_admin_is_redirected_to_verification_from_dashboard(): void
    {
        $admin = $this->createMasterAdmin();

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertRedirect(route('admin.verifikasi.index'));
    }

    public function test_master_admin_can_switch_user_status_to_notaris(): void
    {
        $admin = $this->createMasterAdmin();
        $user = User::factory()->create([
            'role' => 'pemohon',
            'status_akun' => 'perorangan',
            'jenis_akun' => 'perorangan',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.update-status', $user), [
            'status_akun' => 'notaris',
            'catatan_verifikasi' => 'Dipindahkan ke Notaris oleh admin.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $user->refresh();
        $this->assertSame('notaris', $user->status_akun);
        $this->assertSame('notaris', $user->jenis_akun);
        $this->assertSame('terverifikasi', $user->status_verifikasi);
        $this->assertNotNull($user->verified_at);
    }

    public function test_master_admin_can_switch_user_status_to_pengacara(): void
    {
        $admin = $this->createMasterAdmin();
        $user = User::factory()->create([
            'role' => 'pemohon',
            'status_akun' => 'perorangan',
            'jenis_akun' => 'perorangan',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.update-status', $user), [
            'status_akun' => 'pengacara',
        ]);

        $response->assertRedirect();

        $user->refresh();
        $this->assertSame('pengacara', $user->status_akun);
        $this->assertSame('pengacara', $user->jenis_akun);
        $this->assertSame('terverifikasi', $user->status_verifikasi);
    }

    public function test_master_admin_can_switch_user_status_to_perorangan(): void
    {
        $admin = $this->createMasterAdmin();
        $user = User::factory()->create([
            'role' => 'pemohon',
            'status_akun' => 'notaris',
            'jenis_akun' => 'notaris',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.update-status', $user), [
            'status_akun' => 'perorangan',
        ]);

        $response->assertRedirect();

        $user->refresh();
        $this->assertSame('perorangan', $user->status_akun);
    }

    public function test_master_admin_cannot_switch_to_invalid_status(): void
    {
        $admin = $this->createMasterAdmin();
        $user = User::factory()->create(['role' => 'pemohon']);

        $response = $this->actingAs($admin)->post(route('admin.verifikasi.update-status', $user), [
            'status_akun' => 'invalid_status',
        ]);

        $response->assertSessionHasErrors('status_akun');
    }
}
