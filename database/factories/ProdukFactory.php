<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'kategori_produk' => $this->faker->randomElement([
                'Elektronik', 'Pakaian', 'Makanan', 'Minuman', 'Aksesoris'
            ]),
            'nama_produk' => $this->faker->words(3, true),
            'harga_produk' => $this->faker->numberBetween(5000, 500000),
            'stok_produk' => $this->faker->numberBetween(1, 100),
            'img_produk' => 'produk.jpg', // atau null
            'status' => $this->faker->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
