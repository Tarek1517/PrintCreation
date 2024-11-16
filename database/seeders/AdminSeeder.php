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
                'name' => 'Tushar - Admin',
                'email' => 'tushar@admin.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('tushar'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jugol - Admin',
                'email' => 'jugol@admin.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('jugol'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eva - Admin',
                'email' => 'eva@admin.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('eva'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Taposh - Admin',
                'email' => 'taposh@admin.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('taposh'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jisan - Admin',
                'email' => 'jisan@admin.com',
                'phone' => '888 999 888',
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'post_code' => '1212',
                'address' => 'Merul Badda, Dhaka 1212',
                'password' => Hash::make('jishan'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}