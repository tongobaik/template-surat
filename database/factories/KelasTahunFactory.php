<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Kela;
use App\Models\KelasTahun;
use App\Models\TahunPelajaran;

class KelasTahunFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KelasTahun::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'kelas_id' => Kela::factory(),
            'tahun_pelajaran_id' => TahunPelajaran::factory(),
        ];
    }
}
