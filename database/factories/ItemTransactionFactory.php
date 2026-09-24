<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemTransaction>
 */
class ItemTransactionFactory extends Factory
{
    protected $model = ItemTransaction::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'nama_peminjam' => fake()->name(),
            'divisi' => fake()->randomElement(['Pengawasan', 'SDM', 'Hukum', 'Humas', 'Sekretariat']),
            'tanggal_pinjam' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'tanggal_kembali' => null,
            'catatan' => fake()->sentence(),
        ];
    }

    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_kembali' => now()->format('Y-m-d'),
        ]);
    }
}
