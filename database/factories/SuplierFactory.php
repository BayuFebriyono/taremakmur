<?php

namespace Database\Factories;

use App\Models\Suplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Suplier>
 */
class SuplierFactory extends Factory
{
    protected $model = Suplier::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $satuanOptions = ['PCS', 'BOX', 'KILO'];
        return [
            'nama' => $this->faker->name(),
            'nama_barang' => $this->faker->word(),
            'suplier' => $this->faker->company(),
            'satuan' => $this->faker->randomElement($satuanOptions),
            'unit' => $this->faker->randomNumber(3)
        ];
    }
}
