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
            'email' => 'mahesh@reraagents.in',
            'password' => bcrypt('mahesh123'),
            'mobile'    => '9581173535',
            'name' => 'Mahesh Gutta',
            'role' => 10
        ]);
    }
}
