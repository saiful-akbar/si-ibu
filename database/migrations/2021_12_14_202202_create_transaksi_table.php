<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('divisi_id');
            $table->date('tanggal');
            $table->string('kegiatan', 128);
            $table->double('jumlah');
            $table->char('no_dokumen', 32)->unique();
            $table->string('file_dokumen', 128)->nullable()->default(null);
            $table->text('uraian')->nullable()->default(null);
            $table->string('approval', 64);
            $table->timestamps();


            // relasi dengan tabel divisi
            $table->foreign('divisi_id')
                ->references('id')
                ->on('divisi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // relasi dengan tabel user
            $table->foreign('user_id')
                ->references('id')
                ->on('user')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
