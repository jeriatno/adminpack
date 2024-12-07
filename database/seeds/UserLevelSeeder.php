<?php

use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User\UserLevel::insert([
            ['name' => 'president'],
            ['name' => 'director'],
            ['name' => 'division manager'],
            ['name' => 'manager'],
            ['name' => 'staff'],
        ]);
    }
}
