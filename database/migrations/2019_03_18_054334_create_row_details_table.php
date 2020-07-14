<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('row_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('row_id')->unsigned();
            $table->timestamps();

            $table->foreign('row_id')->references('id')
                  ->on('rows')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('row_details');
    }
}
