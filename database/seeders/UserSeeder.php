<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(500)->create();

        DB::table('users')->insert([
            [
                'name' => 'Tushar - Customer',
                'email' => 'customer@customer.com',
                'phone' => '888 999 888',
                'password' => Hash::make('customer'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}