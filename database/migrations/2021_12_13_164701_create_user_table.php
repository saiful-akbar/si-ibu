<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('divisi_id');
            $table->string('username', 128)->unique();
            $table->string('password');
            $table->boolean('active')->default(false);
            $table->timestamps();

            // buat foreign key relasi antar tabel
            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('divisi_id')->references('id')->on('divisi');
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
