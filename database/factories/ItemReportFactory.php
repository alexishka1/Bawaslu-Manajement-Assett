<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemReport>
 */
class ItemReportFactory extends Factory
{
    protected $model = ItemReport::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory()->staff(),
            'kondisi_aktual' => fake()->randomElement(['tersedia', 'terpakai', 'servis', 'rusak', 'hilang']),
            'catatan' => fake()->sentence(),
            'foto_bukti' => 'reports/dummy.jpg',
            'status_validasi' => 'menunggu',
            'divalidasi_oleh' => null,
            'tanggal_validasi' => null,
        ];
    }

    public function validated(?User $validator = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status_validasi' => 'divalidasi',
            'divalidasi_oleh' => $validator?->id ?? User::factory()->admin(),
            'tanggal_validasi' => now(),
        ]);
    }

    public function rejected(?User $validator = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status_validasi' => 'ditolak',
            'divalidasi_oleh' => $validator?->id ?? User::factory()->admin(),
            'tanggal_validasi' => now(),
        ]);
    }
}
