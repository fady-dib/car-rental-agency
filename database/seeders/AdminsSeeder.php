<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'first_name' => 'Fady',
                'last_name' => 'Dib',
                'email' => 'fady.dib55@gmail.com',
                'password' => '$2a$12$9tk0rJAbgk48RVRuvOoYrO3qHuGD9jzTRPwF1JwgWKMnfFCdqLPOO',
                'blocked' => '0',
                'created_at' => '2024-12-31 13:01:41',
                'updated_at' => '2024-12-31 13:01:41'
            ],
        ];

        foreach ($data as $row) {
            \App\Models\Admin::create($row);
            
        }

    }
}
