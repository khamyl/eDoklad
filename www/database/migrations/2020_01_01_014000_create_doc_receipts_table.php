<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');                                
            
            $table->integer('sum_no_vat');
            $table->integer('vat');
            $table->integer('sum');
            $table->string ('uid', 100)->nullable(); //Receipt unique ID

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_receipts');
    }
}
