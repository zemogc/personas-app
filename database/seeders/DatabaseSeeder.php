<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->admin()->create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
        ]);

        User::factory()->create([
            'name' => 'Lector Demo',
            'email' => 'lector@example.com',
        ]);

        $this->call(GeografiaSeeder::class);
    }
}
