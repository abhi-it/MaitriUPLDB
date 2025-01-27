<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_details', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('animal_type')->nullable();
            $table->string('breeds')->nullable();
            $table->string('cattle_no')->nullable();
            $table->string('milk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_details');
    }
}
