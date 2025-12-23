<?php

namespace Database\Seeders;

use Domain\Clinic\Models\Clinic;
use Domain\Commission\Models\Commission;
use Domain\User\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'is_admin' => true,
            'name' => 'Lex van der Woude',
            'email' => 'lex@bizhub.co.nz',
        ]);

        $clinic = Clinic::factory()->create();

        User::factory()->create([
            'clinic_id' => $clinic->id,

            'name' => 'Test Clinic',
            'email' => 'clinic@bizhub.co.nz',
        ]);
    }
}
