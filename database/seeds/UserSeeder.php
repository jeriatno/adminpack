<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@pack.test',
            'password' => Hash::make('password'),
            'is_active' => 1,
            'password_changed_at' => now()
        ]);

        $admin->roles()->attach(1);
    }
}
