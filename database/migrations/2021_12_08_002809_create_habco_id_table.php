<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHabcoIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habco_id', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
        });
        DB::table('habco_id')->insert([
            'id' => 100_000,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('patients')
            ->update(['habco_id' => null]);
        Schema::dropIfExists('habco_id');
    }
}
