<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocOcrImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_imgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            
            $table->string('url', 512);
            $table->string('fname', 255);
            $table->string('format', 45);
            $table->string('size', 45);
            $table->string('name', 50)->nullable();
            $table->text  ('ocr_data')->nullable();   
            
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
        Schema::dropIfExists('doc_imgs');
    }
}
