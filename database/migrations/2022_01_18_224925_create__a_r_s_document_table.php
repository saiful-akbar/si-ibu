<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARSDocumentTable extends Migration
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
            ->create('ARSDocument', function (Blueprint $table) {
                $table->increments('ARSDocument_PK');
                $table->unsignedInteger('MSARSCategory_FK');
                $table->unsignedInteger('MSARSType_FK');
                $table->date('DateDoc')->nullable();
                $table->string('Number', 50)->nullable();
                $table->binary('Dokumen')->nullable();
                $table->string('NamaFile', 200)->nullable();
                $table->timestamp('DateAdds')->nullable()->default(null);
                $table->year('Years')->nullable();
                $table->smallInteger('Is_Publish')->nullable();


                // $table->foreign('MSARSCategory_FK')
                //     ->references('MSARSCategory_PK')
                //     ->on('MSARSCategory')
                //     ->cascadeOnUpdate();

                // $table->foreign('MSARSType_FK')
                //     ->references('MSARSType_PK')
                //     ->on('MSARSType')
                //     ->cascadeOnUpdate();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->dropIfExists('ARSDocument');
    }
}
