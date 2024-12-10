<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CraeteAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'phone' => '01144556678',
            'email' => 'kareemashraf20011@gmail.com',
            'day' => 22,
            'month' => 8,
            'year' => 2001,
            'password' => Hash::make('85208520'),
            'status' => 1,
            'tenant_id' => null,
        ]);
        echo "Seeder executed successfully: New admin granted to 'User'\n";
    }
}
