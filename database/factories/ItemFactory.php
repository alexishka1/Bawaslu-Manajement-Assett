<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'kode_bmn' => 'BMN-'.fake()->unique()->numerify('###-####'),
            'nama_barang' => fake()->words(3, true),
            'kategori' => fake()->randomElement(['Elektronik', 'ATK', 'Kendaraan', 'Mebel', 'Arsip']),
            'foto' => null,
            'lokasi_simpan' => 'Gudang '.fake()->randomElement(['A', 'B', 'C', 'Lt. 2']),
            'status' => 'tersedia',
        ];
    }

    public function terpakai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'terpakai',
        ]);
    }

    public function rusak(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rusak',
        ]);
    }

    public function servis(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'servis',
        ]);
    }
}
