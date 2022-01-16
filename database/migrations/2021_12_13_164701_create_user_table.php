<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
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
            ->create('user', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('divisi_id');
                $table->string('username', 128)->unique();
                $table->string('password');
                $table->string('seksi', 128);
                $table->boolean('active')->default(false);
                $table->timestamps();

                // relasi dengan table divisi
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
        Schema::dropIfExists('user');
    }
}
