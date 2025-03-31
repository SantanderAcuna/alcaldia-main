<?php

namespace Database\Seeders;

use App\Models\Pqrsd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PqrsdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pqrsd::factory(10)->create();
    }
}
