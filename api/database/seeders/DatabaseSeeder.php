<?php

namespace Database\Seeders;

use App\Models\Pqrsd;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Pqrsd::factory(10)->create();
        User::factory(10)->create();
        
        User::factory()->create([
            'name' => 'jose acuña',
            'email' => 'santanderjose19@gmail.com',
            'password' => '85154239',
           
        ]);
    }
}
