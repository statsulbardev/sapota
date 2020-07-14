<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeOnPemeriksaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemeriksaan', function (Blueprint $table) {
            $table->dropColumn(['tanggal_cek', 'supervisor', 'catatan']);
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
            $table->timestamp('tanggal_cek')->nullable();
            $table->integer('supervisor')->nullable();
            $table->text('catatan')->nullable();
        });
    }
}
