<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisBelanjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_belanja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('divisi_id');
            $table->string('kategori_belanja', 128);
            $table->boolean('active')->default(true);
            $table->timestamps();

            // relasi dengan table divisi
            $table->foreign('divisi_id')
                ->references('id')
                ->on('divisi')
                ->cascadeOnUpdate()
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
