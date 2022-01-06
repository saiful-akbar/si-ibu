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
            $table->unsignedBigInteger('budget_id');
            $table->date('tanggal');
            $table->string('kegiatan', 128);
            $table->decimal('jumlah_nominal', 18, 0);
            $table->string('no_dokumen', 100)->unique();
            $table->string('file_dokumen', 128)->nullable()->default(null);
            $table->text('uraian')->nullable()->default(null);
            $table->string('approval', 128);
            $table->timestamps();

            // relasi dengan tabel user
            $table->foreign('user_id')
                ->references('id')
                ->on('user');

            // relasi dengan tabel jenis_belanja
            $table->foreign('budget_id')
                ->references('id')
                ->on('budget');
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
