<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaitriPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maitri_portals', function (Blueprint $table) {
            $table->id();
            $table->string('mandal');
            $table->unsignedBigInteger('maitri_districts_lat_long_id');
            $table->string('tehsil');
            $table->string('development_area');
            $table->string('veterinary_hospital_name');
            $table->string('gram_panchayat_name');
            $table->string('work_area');
            $table->string('private_artificial_insemination_worker');
            $table->string('address');
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
        Schema::dropIfExists('maitri_portals');
    }
}
