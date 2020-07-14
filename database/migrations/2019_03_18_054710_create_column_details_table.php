<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('column_id')->unsigned();
            $table->timestamps();

            $table->foreign('column_id')->references('id')
                  ->on('column')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_details');
    }
}
