<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePriceIdColumnInPricePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_property', function (Blueprint $table) {
            $table->renameColumn('Price_id', 'price_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_property', function (Blueprint $table) {
            $table->renameColumn('price_id', 'Price_id');
        });
    }
}
