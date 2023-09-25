<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumOfMaitriesToMaitriDistrictsLatLong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maitri_districts_lat_long', function (Blueprint $table) {
            $table->integer('numOfMaitries')->nullable()->default(0)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('maitri_districts_lat_long', function (Blueprint $table) {
            //
        });
    }
}
