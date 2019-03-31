<?php

use Illuminate\Database\Seeder;
use App\PropertyType;

class PropertyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropertyType::create(['type' => 'Agriculture Land', 'slug' => str_slug('Agriculture Land')]);
        PropertyType::create(['type' => 'Commercial-Income', 'slug' => str_slug('Commercial-Income')]);
        PropertyType::create(['type' => 'Commercial Plots', 'slug' => str_slug('Commercial Plots')]);
        PropertyType::create(['type' => 'Development Sites', 'slug' => str_slug('Development Sites')]);
        PropertyType::create(['type' => 'Individual House', 'slug' => str_slug('Individual House')]);
        PropertyType::create(['type' => 'PLOT IN RESORTS', 'slug' => str_slug('PLOT IN RESORTS')]);
        PropertyType::create(['type' => 'Resale-Flats', 'slug' => str_slug('Resale-Flats')]);
        PropertyType::create(['type' => 'Residential Plots', 'slug' => str_slug('Residential Plots')]);
        PropertyType::create(['type' => 'Venture-plots', 'slug' => str_slug('Venture-plots')]);
    }
}
