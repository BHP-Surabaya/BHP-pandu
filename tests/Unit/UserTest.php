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
}
