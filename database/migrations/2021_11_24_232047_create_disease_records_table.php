<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseaseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_records', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->primary('user_id');

            $table->boolean('covid_19')->default(false);
            $table->boolean('respiratory')->default(false);
            $table->boolean('infectious')->default(false);
            $table->boolean('vascular')->default(false);
            $table->boolean('cancer')->default(false);
            $table->boolean('imuloical')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('dangerous_area')->default(false);
            $table->boolean('pet')->default(false);

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
        Schema::dropIfExists('disease_records');
    }
}
