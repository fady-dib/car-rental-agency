<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'name' => 'Fady Dib',
                'email' => 'fady.dib@hotmail.com',
                'password' => '$2a$12$9tk0rJAbgk48RVRuvOoYrO3qHuGD9jzTRPwF1JwgWKMnfFCdqLPOO',
                'created_at' => '2024-12-31 13:01:41',
                'updated_at' => '2024-12-31 13:01:41'
            ],
        ];

        foreach ($data as $row) {
            \App\Models\User::create($row);
            
        }
    }
}
