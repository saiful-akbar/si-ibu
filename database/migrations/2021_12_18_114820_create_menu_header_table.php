<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuHeaderTable extends Migration
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
            ->create('menu_header', function (Blueprint $table) {
                $table->id();
                $table->string('nama_header', 128)->unique();
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
        Schema::dropIfExists('menu_header');
    }
}
