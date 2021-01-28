<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonRole;

class PersonRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PersonRole::insert([
            [
                'name' => 'Residente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Visitante',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
