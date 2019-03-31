<?php

use Illuminate\Database\Seeder;
use App\Face;

class FacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Face::create(['face' => 'North', 'slug' => str_slug('North')]);
        Face::create(['face' => 'East', 'slug' => str_slug('East')]);
        Face::create(['face' => 'West', 'slug' => str_slug('West')]);
        Face::create(['face' => 'South', 'slug' => str_slug('South')]);
    }
}
