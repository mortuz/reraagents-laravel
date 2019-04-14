<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(PropertyTypesTableSeeder::class);
        $this->call(BHKSTableSeeder::class);
        $this->call(FacesTableSeeder::class);
        $this->call(VenturesTableSeeder::class);
        $this->call(AgentProfilesTableSeeder::class);
    }
}
