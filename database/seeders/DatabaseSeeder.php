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
        // User::factory(10)->create();
        User::factory()->create(
            [
                'name' => 'Christine de Guzman',
                'email' => 'admin@gmail.com',
                'contact_number' => '09678303010',
                'password' => bcrypt('12345'),
                'account_type' => 'client'
            ]
        );
    }
}
