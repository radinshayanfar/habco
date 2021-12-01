<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
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
        \App\Models\User::factory()
            ->count(20)
            ->state(new Sequence(
                ['role' => 'patient'],
                ['role' => 'doctor'],
                ['role' => 'nurse'],
                ['role' => 'pharmacist'],
                ['role' => 'admin'],
            ))
            ->create();

    }
}
