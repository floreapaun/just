<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('courts')->insert([
            ['name' => 'C1'],
            ['name' => 'C2'],
            ['name' => 'C3'],
            ['name' => 'C4'],
            ['name' => 'C5'],
            ['name' => 'C6'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courts');
    }
}
