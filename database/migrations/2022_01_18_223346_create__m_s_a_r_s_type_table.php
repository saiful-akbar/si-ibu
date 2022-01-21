<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSARSTypeTable extends Migration
{
    protected $connection = 'arsip';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->create('MSARSType', function (Blueprint $table) {
                $table->increments('MSARSType_PK');
                $table->unsignedInteger('MSARSCategory_FK');
                $table->string('Nama', 200)->unique()->nullable();

                $table->foreign('MSARSCategory_FK')
                    ->references('MSARSCategory_PK')
                    ->on('MSARSCategory')
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
        Schema::connection('arsip')
            ->dropIfExists('MSARSType');
    }
}
