<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLandmarkAndAreaAndPremiumToAgentProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_profiles', function (Blueprint $table) {
            $table->integer('area_id')->nullable();
            $table->integer('landmark_id')->nullable();
            $table->boolean('premium')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_profiles', function (Blueprint $table) {
            $table->dropColumn(['landmark', 'area', 'premium']);
        });
    }
}
