<?php

use Illuminate\Database\Seeder;
use App\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'name' => 'Andhra Pradesh',
            'slug' => str_slug('Andhra Pradesh'),
            'status' => 1
        ]);

        State::create([
            'name' => 'Telangana',
            'slug' => str_slug('Telangana'),
            'status' => 0
        ]);

        State::create([
            'name' => 'Tamil Nadu',
            'slug' => str_slug('Tamil Nadu'),
            'status' => 0
        ]);

        State::create([
            'name' => 'Karnataka',
            'slug' => str_slug('Karnataka'),
            'status' => 0
        ]);

        State::create([
            'name' => 'Maharashtra',
            'slug' => str_slug('Maharashtra'),
            'status' => 0
        ]);

        State::create([
            'name' => 'Mumbai',
            'slug' => str_slug('Mumbai'),
            'status' => 0
        ]);
    }
}
