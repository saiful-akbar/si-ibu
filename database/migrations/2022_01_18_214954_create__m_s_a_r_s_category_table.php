<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSARSCategoryTable extends Migration
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
            ->create('MSARSCategory', function (Blueprint $table) {
                $table->increments('MSARSCategory_PK');
                $table->string('Name', 50)->nullable();
                $table->string('Description', 50)->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('arsip')->dropIfExists('MSARSCategory');
    }
}
