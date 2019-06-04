<?php

use Illuminate\Database\Seeder;
use App\LoanPurpose;

class LoanPurposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanPurpose::create(['purpose' => 'Purchase of house/flat']);
        LoanPurpose::create(['purpose' => 'Purchase of plot/land']);
        LoanPurpose::create(['purpose' => 'Private finance']);
    }
}
