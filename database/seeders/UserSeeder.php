<?php

namespace Database\Seeders;

use App\Http\Domains\User\Model\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run()
    {
        User::create([
            'name' => 'Admin',
        ]);

        User::create([
            'name' => 'Mahmoud',
        ]);
    }
}
