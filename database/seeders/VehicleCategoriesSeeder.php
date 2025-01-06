<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Economy',
                'created_at' => '2024-12-31 13:01:41',
                'updated_at' => '2024-12-31 13:01:41'
            ],
            [
                'name' => 'Luxury',
                'created_at' => '2024-12-31 13:01:41',
                'updated_at' => '2024-12-31 13:01:41'
            ],
            [
                'name' => 'SUV',
                'created_at' => '2024-12-31 13:01:41',
                'updated_at' => '2024-12-31 13:01:41'
            ],
        ];

        foreach ($data as $row) {
            \App\Models\VehicleCategory::create($row);
        }
    }
}
