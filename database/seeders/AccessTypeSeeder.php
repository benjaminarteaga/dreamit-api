<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessType;

class AccessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccessType::insert([
            [
                'name' => 'Entrada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salida',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
