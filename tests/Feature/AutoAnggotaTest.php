<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Anggota;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AutoAnggotaTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_registration_automatically_creates_anggota()
    {
        $response = $this->post('/register', [
            'name' => 'Siswa Baru Otomatis',
            'email' => 'siswabaru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => 'siswabaru@example.com',
        ]);

        $this->assertDatabaseHas('anggota', [
            'nama_anggota' => 'Siswa Baru Otomatis',
            'kelas'        => null,
            'tempatlahir'  => null,
            'tgllahir'     => null,
        ]);
    }

    public function test_peminjaman_index_filtering()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Filter status dipinjam
        $response = $this->actingAs($admin)->get('/peminjaman?status=dipinjam');
        $response->assertStatus(200);

        // Filter status selesai
        $response = $this->actingAs($admin)->get('/peminjaman?status=selesai');
        $response->assertStatus(200);

        // Filter denda ada
        $response = $this->actingAs($admin)->get('/peminjaman?denda=ada');
        $response->assertStatus(200);

        // Filter denda tanpa
        $response = $this->actingAs($admin)->get('/peminjaman?denda=tanpa');
        $response->assertStatus(200);

        // Filter rentang tanggal
        $response = $this->actingAs($admin)->get('/peminjaman?tgl_mulai=2026-09-01&tgl_selesai=2026-10-05');
        $response->assertStatus(200);
    }
}
