<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaitriDistrictsLatLongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maitri_districts_lat_long', function (Blueprint $table) {
            $table->id();
            $table->string('district')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
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
        Schema::dropIfExists('districts_lat_long');
    }
}
