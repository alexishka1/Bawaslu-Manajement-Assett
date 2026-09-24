<?php

namespace Database\Factories;

use App\Models\RefRuangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefRuangan>
 */
class RefRuanganFactory extends Factory
{
    protected $model = RefRuangan::class;

    public function definition(): array
    {
        return [
            'kode_ruangan' => 'R-'.fake()->unique()->numerify('###'),
            'nama_ruangan' => 'Ruang '.fake()->words(2, true),
            'lantai' => 'Lantai '.fake()->randomElement(['1', '2', '3']),
            'gedung' => 'Gedung '.fake()->randomElement(['Utama', 'Sayap Barat', 'Sayap Timur']),
            'penanggung_jawab' => fake()->name(),
            'nip_penanggung_jawab' => fake()->numerify('19##########00#'),
            'keterangan' => fake()->sentence(),
        ];
    }
}
