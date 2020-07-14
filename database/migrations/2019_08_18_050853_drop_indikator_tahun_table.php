<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIndikatorTahunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('indikator_tahun');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('indikator_tahun', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indikator_id')->unsigned()->index();
            $table->integer('tahun')->unsigned();
            $table->timestamps();
        });
    }
}
