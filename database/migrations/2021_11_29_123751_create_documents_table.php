<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
//            $table->binary('file');
            $table->string('file_type');
            $table->boolean('verified')->default(false);
            $table->text('verification_explanation')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
        DB::statement("ALTER TABLE documents ADD file MEDIUMBLOB AFTER id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
