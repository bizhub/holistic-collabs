<?php

namespace Database\Seeders;

use Domain\User\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Lex van der Woude',
            'email' => 'lex@bizhub.co.nz',
        ]);
    }
}
