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
        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
        ]);

        $this->call(GeografiaSeeder::class);
    }
}
