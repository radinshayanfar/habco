<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->boolean('covid_19')->nullable();
            $table->boolean('respiratory')->nullable();
            $table->boolean('infectious')->nullable();
            $table->boolean('vascular')->nullable();
            $table->boolean('cancer')->nullable();
            $table->boolean('imuloical')->nullable();
            $table->boolean('diabetes')->nullable();
            $table->boolean('dangerous_area')->nullable();
            $table->boolean('pet')->nullable();
            $table->boolean('med_staff')->nullable();

            $table->integer('habco_id')->unique()->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
