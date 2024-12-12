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
        TahunPelajaran::create([
            'nama' => '2024/2025',
            'is_active' => true,
        ]);
        TahunPelajaran::create([
            'nama' => '2025/2026',
            'is_active' => false,
        ]);
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
        Siswa::create([
            'nama' => 'Pupung Munawaroh',
            'nisn' => '1234567890',
            'jenis_kelamin' => 'Perempuan',
            'kelas_id' => 1,
            'status_verval' => null,
        ]);
        Siswa::create([
            'nama' => 'Yahya Zulfikri',
            'nisn' => '0000971291',
            'jenis_kelamin' => 'Laki-laki',
            'kelas_id' => 2,
            'status_verval' => null,
        ]);
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'adm@mtsn1pandeglang.sch.id',
            'is_active' => true,
            'is_admin' => 'Administrator',
        ]);
        User::factory()->create([
            'name' => 'Yahya Zulfikri',
            'username' => '0000971291',
            'email' => '0000971291@mtsn1pandeglang.sch.id',
            'is_active' => true,
            'is_admin' => 'Siswa',
        ]);
        User::factory()->create([
            'name' => 'Pupung Munawaroh',
            'username' => '1234567890',
            'email' => '1234567890@mtsn1pandeglang.sch.id',
            'is_active' => false,
            'is_admin' => 'Siswa',
        ]);
    }
}
