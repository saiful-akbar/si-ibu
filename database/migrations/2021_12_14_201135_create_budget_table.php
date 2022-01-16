<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetTable extends Migration
{
    /**
     * koneksi database
     */
    protected $connection = 'sqlsrv';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')
            ->create('budget', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('divisi_id');
                $table->unsignedBigInteger('jenis_belanja_id');
                $table->year('tahun_anggaran');
                $table->decimal('nominal', 18, 0)->default(0);
                $table->decimal('sisa_nominal', 18, 0)->default(0);
                $table->text('keterangan')->nullable()->default(null);
                $table->timestamps();

                // relasi dengan tabel divisi
                $table->foreign('jenis_belanja_id')
                    ->references('id')
                    ->on('jenis_belanja');

                // relasi dengan tabel divisi
                $table->foreign('divisi_id')
                    ->references('id')
                    ->on('divisi');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget');
    }
}
