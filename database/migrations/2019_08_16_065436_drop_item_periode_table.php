<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropItemPeriodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('item_periode');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('item_periode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('periode_id')
                  ->unsigned();
            $table->timestamps();

            $table->foreign('periode_id')
                  ->references('id')
                  ->on('periode')
                  ->onUpdate('cascade');
        });
    }
}
