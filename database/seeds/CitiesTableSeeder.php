<?php

use Illuminate\Database\Seeder;
use App\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name' => 'Amaravathi',
            'slug' => str_slug('Amaravathi'),
            'state_id' => 1,
        ]);

        City::create([
            'name' => 'Guntur',
            'slug' => str_slug('Guntur'),
            'state_id' => 1,
            'status' => 1
        ]);
        City::create([
            'name' => 'Mangalagiri',
            'slug' => str_slug('Mangalagiri'),
            'state_id' => 1,
        ]);

        City::create([
            'name' => 'Tenali',
            'slug' => str_slug('Tenali'),
            'state_id' => 1,
        ]);

        City::create([
            'name' => 'Vijayawada',
            'slug' => str_slug('Vijayawada'),
            'state_id' => 1,
        ]);

        City::create([
            'name' => 'Secundrabad',
            'slug' => str_slug('Secundrabad'),
            'state_id' => 2,
        ]);

        City::create([
            'name' => 'Chennai',
            'slug' => str_slug('Chennai'),
            'state_id' => 3,
        ]);

        City::create([
            'name' => 'Kanchipuram',
            'slug' => str_slug('Kanchipuram'),
            'state_id' => 3,
        ]);

        City::create([
            'name' => 'Bangalore',
            'slug' => str_slug('Bangalore'),
            'state_id' => 4,
        ]);
    }
}
