<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevokesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revokes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files');
            $table->date('date');
            $table->string('parts');
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revokes');
    }
}
