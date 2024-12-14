<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Verifikasi;
use App\Models\TahunPelajaran;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // TahunPelajaran
        TahunPelajaran::create([
            'nama' => '2024/2025',
            'is_active' => true,
        ]);
        TahunPelajaran::create([
            'nama' => '2025/2026',
            'is_active' => false,
        ]);

        // Kelas
        Kelas::create([
            'nama' => 'XI A',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI B',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI C',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI D',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI E',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI F',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI G',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI H',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI I',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);
        Kelas::create([
            'nama' => 'XI J',
            'tingkat' => 'XI',
            'tahun_pelajaran_id' => 1,
        ]);


        // Siswa
        // Siswa::create(['nama' => 'NAMA SISWA', 'nisn' => 'NISN SISWA', 'nik' => 'NIK SISWA', 'tempat_lahir' => 'TEMPAT LAHIR', 'tanggal_lahir' => 'TANGGAL LAHIR', 'jenis_kelamin' => 'JENIS KELAMIN', 'nama_ayah' => 'NAMA AYAH', 'nama_ayah' => 'NAMA IBU', 'kelas_id' => 1, 'status_verval' => 0,]);
        Siswa::create(['nama' => 'YAHYA ZULFIKRI', 'nisn' => '1234567890', 'nik' => '1234567890123456', 'tempat_lahir' => 'PANDEGLANG', 'tanggal_lahir' => '2000-01-14', 'jenis_kelamin' => 'Laki-laki', 'nama_ayah' => 'NAMA AYAH', 'nama_ibu' => 'NAMA IBU', 'kelas_id' => 1, 'status_verval' => 0,]);

        // Kelas IX A : kelas_id = 1

        // Kelas IX B : kelas_id = 2

        // Kelas IX C : kelas_id = 3

        // Kelas IX D : kelas_id = 4

        // Kelas IX E : kelas_id = 5

        // Kelas IX F : kelas_id = 6

        // Kelas IX G : kelas_id = 7

        // Kelas IX H : kelas_id = 8

        // Kelas IX I : kelas_id = 9

        // Kelas IX J : kelas_id = 10


        // User
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'adm@mtsn1pandeglang.sch.id',
            'is_active' => true,
            'is_admin' => 'Administrator',
        ]);
        User::factory()->create(['name' => 'Yahya Zulfikri', 'username' => '1234567890', 'email' => '1234567890@mtsn1pandeglang.sch.id', 'is_active' => true, 'is_admin' => 'Siswa',]);
    }
}
