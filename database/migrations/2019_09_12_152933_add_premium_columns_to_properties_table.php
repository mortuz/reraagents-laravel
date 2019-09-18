<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPremiumColumnsToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->text('highlights')->nullable();
            $table->text('overview')->nullable();
            $table->text('amenities')->nullable();
            $table->text('floor_plans')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('highlights');
            $table->dropColumn('overview');
            $table->dropColumn('amenities');
            $table->dropColumn('floor_plans');
        });
    }
}
