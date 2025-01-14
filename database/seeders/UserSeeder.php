<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin JDS Kost',
                'email' => 'jdskost@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'image_ktp' => 'path/to/ktp_image.jpg',
                'phone_number' => '081234567890',
                'emergency_phone' => 'Asep (081234567891)',
                'image_selfie' => 'path/to/selfie_image.jpg',
                'job' => 'Software Engineer',
                'long_stay' => '6 Bulan',
                'role' => 'admin',
                'no_rek' => '_xxxx_',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
