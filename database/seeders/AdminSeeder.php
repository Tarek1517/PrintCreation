<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name' => 'Sign & Print Creation',
                'email' => 'admin@print.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('print'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}