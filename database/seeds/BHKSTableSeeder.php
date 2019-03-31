<?php

use Illuminate\Database\Seeder;
use App\BHK;

class BHKSTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BHK::create(['type' => '1-BHK', 'slug' => str_slug('1-BHK')]);
        BHK::create(['type' => '2-BHK', 'slug' => str_slug('2-BHK')]);
        BHK::create(['type' => '3-BHK', 'slug' => str_slug('3-BHK')]);
        BHK::create(['type' => '4-BHK', 'slug' => str_slug('4-BHK')]);
        BHK::create(['type' => '5-BHK', 'slug' => str_slug('5-BHK')]);
        BHK::create(['type' => '6-BHK', 'slug' => str_slug('6-BHK')]);
    }
}
