<?php

use App\Amenity;
use Illuminate\Database\Seeder;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Amenity::create(['name' => 'Night Club']);
        Amenity::create(['name' => 'Gym']);
        Amenity::create(['name' => 'Playground']);
        Amenity::create(['name' => 'Swimming Pool']);
        Amenity::create(['name' => 'Shopping Mall']);
    }
}
