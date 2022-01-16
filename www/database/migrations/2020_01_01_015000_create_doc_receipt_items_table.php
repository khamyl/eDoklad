<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doc_receipt_id');

            $table->string ('name', 350);    
            $table->integer('quantity');    
            $table->integer('price');                
            $table->integer('price_no_vat');
            $table->integer('vat');
            
            $table->foreign('doc_receipt_id')->references('id')->on('doc_receipts')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_receipt_items');
    }
}
