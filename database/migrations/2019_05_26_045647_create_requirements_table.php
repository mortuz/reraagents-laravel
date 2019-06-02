<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('raw_data')->nullable();
            $table->string('mobile');
            $table->boolean('request_delete')->default(0);
            $table->boolean('inactive')->default(0);
            $table->dateTime('call_date')->nullable();
            $table->date('visit_date')->nullable();
            $table->integer('working_agent')->default(0);
            $table->boolean('handled_by')->nullable(); // 1 for company | 0 for agent
            $table->integer('status')->default(0); // 0 new | 1 released | 2 rejected
            $table->integer('customer_status_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirements');
    }
}
