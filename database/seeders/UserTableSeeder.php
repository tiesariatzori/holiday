<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->where('email', '=', 'tete.atzori.alves@gmail.com')->first();

        if (!$user) {
            User::create(
                [
                    'name'     => 'tiesari',
                    'email'    => 'tete.atzori.alves@gmail.com',
                    'password' => Hash::make('#holiday'),
                    'is_admin' => 'Yes'
                ]
            );

            echo "User created!\n";
        }
    }
}
