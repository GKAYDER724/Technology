<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'role_id' => 2,
                'fullname' => 'Nguyễn Văn Nhân Viên',
                'email' => 'staff@example.com',
                'password' => '12345678',
                'phone' => '0901234567',
                'address' => 'Ninh Kiều, Cần Thơ',
                'date_of_birth' => '2000-05-15',
                'gender' => 'male',
                'province_city' => 'Cần Thơ',
                'status' => 'active',
            ],
            [
                'role_id' => 3,
                'fullname' => 'Nguyễn Văn An',
                'email' => 'an@example.com',
                'password' => '12345678',
                'phone' => '0912345678',
                'address' => 'Ninh Kiều, Cần Thơ',
                'date_of_birth' => '2002-03-20',
                'gender' => 'male',
                'province_city' => 'Cần Thơ',
                'status' => 'active',
            ],
            [
                'role_id' => 3,
                'fullname' => 'Trần Thị Bình',
                'email' => 'binh@example.com',
                'password' => '12345678',
                'phone' => '0923456789',
                'address' => 'Bình Thủy, Cần Thơ',
                'date_of_birth' => '2001-08-12',
                'gender' => 'female',
                'province_city' => 'Cần Thơ',
                'status' => 'active',
            ],
            [
                'role_id' => 3,
                'fullname' => 'Lê Minh Cường',
                'email' => 'cuong@example.com',
                'password' => '12345678',
                'phone' => '0934567890',
                'address' => 'Ninh Kiều, Cần Thơ',
                'date_of_birth' => '2003-01-10',
                'gender' => 'male',
                'province_city' => 'Cần Thơ',
                'status' => 'active',
            ],
            [
                'role_id' => 3,
                'fullname' => 'Phạm Thị Dung',
                'email' => 'dung@example.com',
                'password' => '12345678',
                'phone' => '0945678901',
                'address' => 'Cái Răng, Cần Thơ',
                'date_of_birth' => '2002-11-25',
                'gender' => 'female',
                'province_city' => 'Cần Thơ',
                'status' => 'inactive',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
