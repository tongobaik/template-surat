<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KelasTahun;
use App\Models\Siswa;

class SiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'nisn' => $this->faker->word(),
            'nik' => $this->faker->word(),
            'tempat_lahir' => $this->faker->word(),
            'tanggal_lahir' => $this->faker->date(),
            'is_active' => $this->faker->boolean(),
            'jenis_kelamin' => $this->faker->randomElement(["Laki-laki","Perempuan"]),
            'nama_ayah' => $this->faker->word(),
            'nama_ibu' => $this->faker->word(),
            'kelas_tahun_id' => KelasTahun::factory(),
        ];
    }
}
