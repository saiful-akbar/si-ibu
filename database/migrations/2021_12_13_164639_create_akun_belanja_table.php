<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunBelanjaTable extends Migration
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
            ->create('akun_belanja', function (Blueprint $table) {
                $table->id();
                $table->string('nama_akun_belanja', 128)->unique();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akun_belanja');
    }
}
