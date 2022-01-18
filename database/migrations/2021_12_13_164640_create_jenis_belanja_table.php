<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBelanjaTable extends Migration
{
    /**
     * koneksi database
     */
    protected $connection = 'anggaran';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('anggaran')
            ->create('jenis_belanja', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('akun_belanja_id');
                $table->string('kategori_belanja', 128);
                $table->boolean('active')->default(true);
                $table->timestamps();

                $table->foreign('akun_belanja_id')
                    ->references('id')
                    ->on('akun_belanja')
                    ->cascadeOnUpdate();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_belanja');
    }
}
