<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Suplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{

    protected $model = Barang::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $suplier = Suplier::inRandomOrder()->first();

        return [
            'suplier_id' => $suplier->id,
            'kode_barang' => uniqid(),
            'nama_barang' => $this->faker->words(3, true),
        ];
    }
}
