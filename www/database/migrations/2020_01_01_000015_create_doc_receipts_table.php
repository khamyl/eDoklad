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
            $table->unsignedBigInteger('source_type_id');            

            $table->decimal('sum_no_vat');
            $table->integer('vat');
            $table->decimal('sum');
            $table->string ('uid', 100)->nullable(); //Receipt unique ID

            $table->foreign('source_type_id')->references('id')->on('source_types')->onDelete('cascade');
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
