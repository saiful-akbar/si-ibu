<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_belanja_id');
            $table->year('tahun_anggaran');
            $table->decimal('nominal', 18, 0);
            $table->text('keterangan')->nullable()->default(null);
            $table->timestamps();

            // relasi dengan tabel divisi
            $table->foreign('jenis_belanja_id')
                ->references('id')
                ->on('jenis_belanja');
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
