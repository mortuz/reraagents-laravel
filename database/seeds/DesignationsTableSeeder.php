<?php

use Illuminate\Database\Seeder;
use App\Designation;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::create([
            'designation' => 'Engineer',
            'slug' => str_slug('Engineer')
        ]);
        Designation::create([
            'designation' => 'Doctor',
            'slug' => str_slug('Doctor')
        ]);
        Designation::create([
            'designation' => 'Businessman',
            'slug' => str_slug('Businessman')
        ]);
        Designation::create([
            'designation' => 'Teacher',
            'slug' => str_slug('Teacher')
        ]);
        Designation::create([
            'designation' => 'Professor',
            'slug' => str_slug('Professor')
        ]);
    }
}
