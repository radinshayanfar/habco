<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->unsignedBigInteger('cv_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->binary('image')->nullable();
            $table->string('image_type')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cv_id')->references('id')->on('documents');
            $table->foreign('document_id')->references('id')->on('documents');

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
        Schema::dropIfExists('nurses');
    }
}
