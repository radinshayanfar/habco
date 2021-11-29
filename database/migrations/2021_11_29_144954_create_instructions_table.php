<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('nurse_id');
            $table->timestamps();

            $table->foreign('patient_id')->references('user_id')->on('patients');
            $table->foreign('nurse_id')->references('user_id')->on('nurses');

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
        Schema::dropIfExists('instructions');
    }
}
