<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name'  => 'Admin Omah Sinau Semar',
            'email' => 'omahsinausemar@gmail.com',
        ]);

        $this->call([
            LombaSeeder::class,
            BlogSeeder::class,
            GaleriSeeder::class,
        ]);
    }
}
