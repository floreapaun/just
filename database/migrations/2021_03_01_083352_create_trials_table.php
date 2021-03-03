<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('court_id')->unsigned();
            $table->foreign('court_id')->references('id')->on('courts');
            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->date('date'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trials');
    }
}
