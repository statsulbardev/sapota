<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->datetime('tanggal_cek')->nullable()->change();
            $table->integer('supervisor')->nullable()->change();
            $table->text('catatan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->datetime('tanggal_cek')->change();
            $table->integer('supervisor')->change();
            $table->text('catatan')->change();
        });
    }
}
