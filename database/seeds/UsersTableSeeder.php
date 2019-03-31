<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@localhost.com',
            'password' => bcrypt('password'),
            'mobile'    => '8759567638',
            'name' => 'Mortuz Alam',
            'role' => 10
        ]);
    }
}
