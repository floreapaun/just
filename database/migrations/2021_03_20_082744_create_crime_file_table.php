<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrimeFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crime_file', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('crime_id')->unsigned();
            $table->foreign('crime_id')->references('id')->on('crimes');
            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crime_file');
    }
}
