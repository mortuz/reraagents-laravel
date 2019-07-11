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
            'email' => 'mortuz@idevia.in',
            'password' => bcrypt('123123123'),
            'mobile'    => '8759567637',
            'name' => 'Mortuz Alam',
            'role' => 10
        ]);
    }
}
