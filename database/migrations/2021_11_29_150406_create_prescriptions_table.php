<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->enum('status', ['written', 'sent', 'filled', 'transmitted'])->default('written');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('pharmacist_id')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('user_id')->on('doctors');
            $table->foreign('patient_id')->references('user_id')->on('patients');
            $table->foreign('pharmacist_id')->references('user_id')->on('pharmacists');

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
        Schema::dropIfExists('prescriptions');
    }
}
