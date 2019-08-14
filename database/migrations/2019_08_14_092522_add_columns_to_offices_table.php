<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->text('coordinates')->nullable();
            $table->boolean('verified')->default(0);
            $table->dateTime('verified_at')->nullable();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('coordinates');
            $table->dropColumn('verified');
            $table->dropColumn('verified_at');
            $table->dropColumn('name');
        });
    }
}
