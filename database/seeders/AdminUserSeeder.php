<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@kapbudiandru.com'],
            [
                'name' => 'Administrator Budiandru',
                'password' => Hash::make('AdminPassword123!'),
                'is_admin' => true,
            ]
        );
    }
}
