<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Test role helper methods on User model.
     */
    public function test_user_role_helpers(): void
    {
        $petugas = new User(['role' => 'petugas']);
        $pemohon = new User(['role' => 'pemohon']);

        $this->assertTrue($petugas->isPetugas());
        $this->assertFalse($petugas->isPemohon());

        $this->assertTrue($pemohon->isPemohon());
        $this->assertFalse($petugas->isPemohon());
    }

    /**
     * Test initial generation from user name.
     */
    public function test_user_initials_accessor(): void
    {
        $singleWord = new User(['name' => 'Petugas']);
        $twoWords = new User(['name' => 'BHP Surabaya']);
        $multipleWords = new User(['name' => 'Balai Harta Peninggalan']);

        $this->assertSame('PE', $singleWord->initials);
        $this->assertSame('BS', $twoWords->initials);
        $this->assertSame('BP', $multipleWords->initials);
    }

    /**
     * Test account status and verification helpers.
     */
    public function test_user_account_status_and_verification_helpers(): void
    {
        $unverifiedNotaris = new User([
            'jenis_akun' => 'notaris',
            'pekerjaan' => 'Notaris',
            'status_akun' => 'perorangan',
            'status_verifikasi' => 'menunggu_verifikasi',
        ]);

        $this->assertTrue($unverifiedNotaris->isNotaris());
        $this->assertTrue($unverifiedNotaris->isVerifikasiPending());
        $this->assertFalse($unverifiedNotaris->isTerverifikasi());
        $this->assertTrue($unverifiedNotaris->isPerorangan());
        $this->assertSame('Akun Perorangan', $unverifiedNotaris->status_akun_label);

        $verifiedPengacara = new User([
            'jenis_akun' => 'pengacara',
            'pekerjaan' => 'Pengacara',
            'status_akun' => 'pengacara',
            'status_verifikasi' => 'terverifikasi',
        ]);

        $this->assertTrue($verifiedPengacara->isPengacara());
        $this->assertFalse($verifiedPengacara->isVerifikasiPending());
        $this->assertTrue($verifiedPengacara->isTerverifikasi());
        $this->assertFalse($verifiedPengacara->isPerorangan());
        $this->assertSame('Akun Pengacara', $verifiedPengacara->status_akun_label);
    }
}
