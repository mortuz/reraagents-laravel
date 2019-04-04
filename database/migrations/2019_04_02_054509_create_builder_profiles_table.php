<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuilderProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builder_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('contact_no')->nullable();
            $table->string('alternative_contact_no')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('builder_profiles');
    }
}
