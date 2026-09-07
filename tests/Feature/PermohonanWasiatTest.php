<?php

namespace Tests\Feature;

use App\Models\Dokumen;
use App\Models\Permohonan;
use App\Models\Pewasiat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PermohonanWasiatTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_permohonan(): void
    {
        $response = $this->get('/permohonan/buat');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_permohonan_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/permohonan/buat');

        $response->assertStatus(200);
        $response->assertSee('Form Pengajuan Wasiat Tertutup');
        $response->assertSee('Informasi Pewasiat');
        $response->assertSee('Informasi Kematian Pewasiat');
        $response->assertSee('Informasi Pencatatan Wasiat');
        $response->assertSee('Informasi Akta Penyimpanan Wasiat');
        $response->assertSee('Informasi Perkawinan Mendiang');
        $response->assertSee('Informasi Anak Pewasiat');
    }

    public function test_user_can_submit_permohonan_tahap_1_single_no_children(): void
    {
        $user = User::factory()->create();

        $payload = [
            'nama_lengkap' => 'Almarhum Ahmad Subarjo',
            'dahulu_bernama' => null,
            'alias' => 'Mbah Barjo',
            'nik' => '3578011234560001',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1955-08-17',
            'tempat_tinggal_terakhir' => 'Jl. Darmo No. 45, Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2026-01-10',
            'nomor_akta_kematian' => 'AK-2026-0012',
            'tanggal_akta_kematian' => '2026-01-15',
            'pejabat_pembuat_akta_kematian' => 'Kota Surabaya',
            'nomor_surat_dpw' => 'AHU.2-00123/2026',
            'tanggal_surat_dpw' => '2026-02-01',
            'status_pencatatan' => 'Terdaftar',
            'nomor_akta_penyimpanan' => 'WST-14/2020',
            'tanggal_akta_penyimpanan' => '2020-05-12',
            'nama_notaris' => 'Hendra Wijaya, S.H., M.Kn.',
            'kedudukan_notaris' => 'Kota Surabaya',
            'status_kawin' => 'tidak_kawin',
            'memiliki_anak' => 'tidak_ada',
        ];

        $response = $this->actingAs($user)->post('/permohonan/buat', $payload);

        $permohonan = Permohonan::where('user_id', $user->id)->latest()->first();
        $response->assertRedirect(route('permohonan.tahap2', $permohonan->id));
        $this->assertDatabaseHas('permohonans', [
            'user_id' => $user->id,
            'status' => 'draft',
        ]);
        $this->assertDatabaseHas('pewasiats', [
            'nama_lengkap' => 'Almarhum Ahmad Subarjo',
            'nik' => '3578011234560001',
            'status_kawin' => 'tidak_kawin',
        ]);
    }

    public function test_user_can_submit_permohonan_tahap_1_with_spouse_and_children(): void
    {
        $user = User::factory()->create();

        $payload = [
            'nama_lengkap' => 'Bambang Hartono',
            'dahulu_bernama' => 'Oei Wie Gwan',
            'alias' => 'Mbah Bambang',
            'nik' => '3578021234560002',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '1950-03-25',
            'tempat_tinggal_terakhir' => 'Jl. Diponegoro No. 88, Surabaya',
            'tempat_kematian' => 'Surabaya',
            'tanggal_kematian' => '2026-02-14',
            'nomor_akta_kematian' => 'AK-2026-0999',
            'tanggal_akta_kematian' => '2026-02-20',
            'pejabat_pembuat_akta_kematian' => 'Kota Surabaya',
            'nomor_surat_dpw' => 'AHU.2-00555/2026',
            'tanggal_surat_dpw' => '2026-03-01',
            'status_pencatatan' => 'Tercatat',
            'nomor_akta_penyimpanan' => 'WST-88/2018',
            'tanggal_akta_penyimpanan' => '2018-11-10',
            'nama_notaris' => 'Siti Nurhaliza, S.H., M.Kn.',
            'kedudukan_notaris' => 'Kota Surabaya',
            'status_kawin' => 'kawin',
            'jenis_dokumen_perkawinan' => 'Buku Nikah',
            'nomor_dokumen_perkawinan' => 'KUA-2015-0988',
            'tanggal_perkawinan' => '2015-06-12',
            'tempat_perkawinan' => 'Kota Surabaya',
            'instansi_penerbit_perkawinan' => 'Kantor Urusan Agama (KUA) Wonokromo',
            'pasangans' => [
                [
                    'nama_lengkap' => 'Endang Rahayu',
                    'nik' => '3578025501700003',
                    'jenis_kelamin' => 'P',
                ],
            ],
            'memiliki_anak' => 'ada',
            'anak' => [
                [
                    'nama_lengkap' => 'Rian Hartono',
                    'nik' => '3578021005950004',
                    'jenis_kelamin' => 'L',
                    'tempat_tanggal_lahir' => 'Surabaya, 10-05-1995',
                    'alamat' => 'Jl. Diponegoro No. 88, Surabaya',
                ],
                [
                    'nama_lengkap' => 'Rina Hartono',
                    'nik' => '3578025008980005',
                    'jenis_kelamin' => 'P',
                    'tempat_tanggal_lahir' => 'Surabaya, 20-08-1998',
                    'alamat' => 'Jl. Manyar Kertoarjo No. 12, Surabaya',
                ],
            ],
        ];

        $response = $this->actingAs($user)->post('/permohonan/buat', $payload);

        $permohonan = Permohonan::where('user_id', $user->id)->latest()->first();
        $response->assertRedirect(route('permohonan.tahap2', $permohonan->id));

        $this->assertDatabaseHas('pewasiats', [
            'nama_lengkap' => 'Bambang Hartono',
            'status_kawin' => 'kawin',
        ]);

        $this->assertDatabaseHas('pasangans', [
            'nama_lengkap' => 'Endang Rahayu',
            'nik' => '3578025501700003',
            'bukti_perkawinan' => 'Buku Nikah',
            'nomor_bukti_perkawinan' => 'KUA-2015-0988',
            'tanggal_kawin' => '2015-06-12',
            'tempat_kawin' => 'Kota Surabaya',
            'pejabat_pembuat_bukti' => 'Kantor Urusan Agama (KUA) Wonokromo',
        ]);

        $this->assertDatabaseHas('ahli_waris', [
            'nama_lengkap' => 'Rian Hartono',
        ]);
        $this->assertDatabaseHas('ahli_waris', [
            'nama_lengkap' => 'Rina Hartono',
        ]);
    }

    public function test_user_can_view_permohonan_index_list(): void
    {
        $user = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-20260902-001',
            'status' => 'draft',
        ]);
        Pewasiat::create([
            'permohonan_id' => $permohonan->id,
            'nama_lengkap' => 'Pewasiat Contoh',
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

        $response = $this->actingAs($user)->get('/permohonan');

        $response->assertStatus(200);
        $response->assertSee('WST-20260902-001');
        $response->assertSee('Pewasiat Contoh');
    }

    public function test_user_can_view_tahap_2_form(): void
    {
        $user = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-20260907-001',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.tahap2', $permohonan->id));

        $response->assertStatus(200);
        $response->assertSee('Form Pengajuan Wasiat Tertutup');
        $response->assertSee('Surat Kuasa');
        $response->assertSee('Akta Kematian');
        $response->assertSee('Surat Keterangan Wasiat');
        $response->assertSee('Akta Penyimpanan Wasiat');
        $response->assertSee('Akta Perkawinan / Buku Nikah pewasiat');
        $response->assertSee('Akta Lahir, KTP dan KK Pasangan dan anak Pewasiat');
        $response->assertSee('Dokumen lainnya');
    }

    public function test_user_cannot_view_other_users_tahap_2(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $owner->id,
            'nomor_permohonan' => 'WST-20260907-002',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($otherUser)->get(route('permohonan.tahap2', $permohonan->id));

        $response->assertStatus(403);
    }

    public function test_user_can_upload_documents_in_tahap_2(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-20260907-003',
            'status' => 'draft',
        ]);

        $payload = [
            'surat_kuasa' => UploadedFile::fake()->create('surat_kuasa.pdf', 500, 'application/pdf'),
            'akta_kematian' => UploadedFile::fake()->create('akta_kematian.pdf', 500, 'application/pdf'),
        ];

        $response = $this->actingAs($user)->post(route('permohonan.tahap2.store', $permohonan->id), $payload);

        $response->assertRedirect(route('permohonan.tahap3', $permohonan->id));

        $this->assertDatabaseHas('dokumens', [
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'surat_kuasa',
            'status' => 'diunggah',
        ]);

        $this->assertDatabaseHas('dokumens', [
            'permohonan_id' => $permohonan->id,
            'jenis_dokumen' => 'akta_kematian',
            'status' => 'diunggah',
        ]);

        $doc = Dokumen::where('permohonan_id', $permohonan->id)->where('jenis_dokumen', 'surat_kuasa')->first();
        Storage::disk('public')->assertExists($doc->file_path);
    }

    public function test_user_can_view_tahap_3_guide(): void
    {
        $user = User::factory()->create([
            'name' => 'Bambang Hartono',
            'nik' => '3578011234560001',
            'phone' => '08123456789',
        ]);
        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-20260907-004',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.tahap3', $permohonan->id));

        $response->assertStatus(200);
        $response->assertSee('Panduan Pemesanan di SIMPADHU AHU');
        $response->assertSee('Buka Portal SIMPADHU AHU');
        $response->assertSee('Bambang Hartono');
        $response->assertSee('3578011234560001');
        $response->assertSee('08123456789');
    }

    public function test_user_cannot_view_other_users_tahap_3(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $owner->id,
            'nomor_permohonan' => 'WST-20260907-005',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($otherUser)->get(route('permohonan.tahap3', $permohonan->id));

        $response->assertStatus(403);
    }

    public function test_user_can_finish_tahap_3_and_status_becomes_menunggu_verifikasi(): void
    {
        $user = User::factory()->create();
        $permohonan = Permohonan::create([
            'user_id' => $user->id,
            'nomor_permohonan' => 'WST-20260907-006',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($user)->post(route('permohonan.tahap3.store', $permohonan->id));

        $response->assertRedirect(route('permohonan.index'));

        $this->assertDatabaseHas('permohonans', [
            'id' => $permohonan->id,
            'status' => 'menunggu_verifikasi',
        ]);
    }
}
