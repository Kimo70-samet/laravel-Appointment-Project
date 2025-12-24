<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء المستخدم الإداري الأول
        User::create([
            'name' => 'المدير العام',
            'email' => 'admin@appointment.com',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_APPROVED,
            'email_verified_at' => now(),
        ]);
    }
}