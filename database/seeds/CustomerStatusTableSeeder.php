<?php

use Illuminate\Database\Seeder;
use App\CustomerStatus;

class CustomerStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerStatus::create(['status' => 'Advance given']);
        CustomerStatus::create(['status' => 'Customer is not clear on requirement']);
        CustomerStatus::create(['status' => 'Deal close']);
        CustomerStatus::create(['status' => 'Property selected']);
        CustomerStatus::create(['status' => 'Visit completed']);
        CustomerStatus::create(['status' => 'Waiting for customer feedback']);
    }
}
