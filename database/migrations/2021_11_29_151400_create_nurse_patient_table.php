<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_patient', function (Blueprint $table) {
            $table->unsignedBigInteger('nurse_id',);
            $table->unsignedBigInteger('patient_id',);
            $table->timestamps();

            $table->primary(['nurse_id','patient_id']);
            $table->foreign('nurse_id')->references('user_id')->on('nurses');
            $table->foreign('patient_id')->references('user_id')->on('patients');

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
        Schema::dropIfExists('nurse_patient');
    }
}
