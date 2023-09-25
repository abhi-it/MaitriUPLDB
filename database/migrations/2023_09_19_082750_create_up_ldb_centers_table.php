<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpLdbCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('up_ldb_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->longText('icon')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->unsignedBigInteger('maitri_districts_lat_long_id')->nullable();
            $table->timestamps();
            $table->foreign('maitri_districts_lat_long_id')->references('id')->on('maitri_districts_lat_long');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('up_ldb_centers');
    }
}
