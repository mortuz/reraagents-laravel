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
            'slug' => str_slug('L&T Group')
        ]);
    }
}
