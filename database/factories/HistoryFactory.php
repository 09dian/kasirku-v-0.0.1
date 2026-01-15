<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        $jumlah = $this->faker->numberBetween(1, 5);
        $harga  = $this->faker->numberBetween(5, 500) * 1000;

        return [
            'invoice'        => 'INV-' . strtoupper($this->faker->bothify('###???')),
            'namaPembeli'    => $this->faker->name(),
            'genderPembeli'  => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'idProduk'       => $this->faker->numberBetween(1, 100),
            'namaProduk'     => $this->faker->words(2, true),
            'jumlahProduk'   => $jumlah,
            'harga'          => $harga,
            'totalHarga'     => $jumlah * $harga,
            'namaKasir'      => $this->faker->name(),
        ];
    }
}
