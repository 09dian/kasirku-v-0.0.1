<?php

namespace Database\Seeders;

use App\Models\History;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     History::factory()->count(10)->create();
    }
}
