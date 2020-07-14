<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropItemSubjekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('item_subjek');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('item_subjek', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->boolean('tampil')->default(false);
            $table->integer('subjek_id')->unsigned();
            $table->timestamps();

            $table->foreign('subjek_id')
                  ->references('id')
                  ->on('subjek')
                  ->onUpdate('cascade');
        });
    }
}
