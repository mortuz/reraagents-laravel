<?php

use Illuminate\Database\Seeder;
use App\AgentProfile;

class AgentProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgentProfile::create([
            'user_id' => 1,
            'state_id' => 1,
            'city_id' => 1
        ]);
    }
}
