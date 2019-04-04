<?php

use Illuminate\Database\Seeder;
use App\Venture;

class VenturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Venture::create([
            'name' => 'L&T Group',
            'slug' => str_slug('L&T Group'),
            'state_id' => 1,
            'city_id' => 1,
        ]);

        Venture::create([
            'name' => 'Pace Builders',
            'slug' => str_slug('Pace Builders'),
            'state_id' => 1,
            'city_id' => 1,
        ]);

        Venture::create([
            'name' => 'Luxury builders',
            'slug' => str_slug('Luxury builders'),
            'state_id' => 1,
            'city_id' => 1,
        ]);
    }
}
