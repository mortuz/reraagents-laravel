<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('raw_data')->nullable();
            $table->string('mobile');
            $table->boolean('for_sale')->default(1);
            $table->text('features')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('google_map')->nullable();
            $table->text('website')->nullable();
            $table->text('images')->nullable();
            $table->boolean('premium')->default(0);
            $table->dateTime('expiry_date')->default(date('Y-m-d H:i:s', strtotime("+30 days")));
            $table->boolean('handled_by')->nullable(); // 1 for company | 0 for agent
            $table->integer('status')->default(0); // 0 new | 1 approved | 2 rejected
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
        Schema::dropIfExists('properties');
    }
}
