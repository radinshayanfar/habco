<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_patient', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id',);
            $table->unsignedBigInteger('patient_id',);

            $table->timestamps();

            $table->primary(['doctor_id','patient_id']);
            $table->foreign('doctor_id')->references('user_id')->on('doctors');
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
        Schema::dropIfExists('doctor_patient');
    }
}
