<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pemasok;

class PemasokSeeder extends Seeder
{
    public function run(): void
    {
        Pemasok::factory()->count(50)->create();
    }
}