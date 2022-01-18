<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMenuHeaderTable extends Migration
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
            ->create('user_menu_header', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('menu_header_id');
                $table->boolean('read')->default(false);
                $table->timestamps();

                $table->foreign('user_id')
                    ->references('id')
                    ->on('user')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

                $table->foreign('menu_header_id')
                    ->references('id')
                    ->on('menu_header')
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
        Schema::dropIfExists('user_menu_header');
    }
}
