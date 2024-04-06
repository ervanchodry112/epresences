<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'nama'      => 'Supervisor',
            'email'     => 'spv@email.com',
            'npp'       => '11111',
            'password'  => bcrypt('password'),
        ]);
        User::factory()->create([
            'nama'      => 'Amanda Bayu',
            'email'     => 'bayu@email.com',
            'npp'       => '12345',
            'npp_supervisor' => '11111',
            'password'  => bcrypt('password'),
        ]);
    }
}
