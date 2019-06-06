<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomerStatusIdColumnNullInRequirementStatusTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requirement_status_transactions', function (Blueprint $table) {
            $table->integer('customer_status_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requirement_status_transactions', function (Blueprint $table) {
            $table->integer('customer_status_id')->nullable(false)->change();
        });
    }
}
