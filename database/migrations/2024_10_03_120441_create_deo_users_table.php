<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deo_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->notNullable();
            $table->integer('zone_id')->unsigned()->notNullable();
            $table->integer('division_id')->unsigned()->notNullable();
            $table->integer('district_id')->unsigned()->notNullable();
            $table->integer('block_id')->unsigned()->notNullable();
            $table->json('aicenters_id');
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
        Schema::dropIfExists('deo_users');
    }
}
