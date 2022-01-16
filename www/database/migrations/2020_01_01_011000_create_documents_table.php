<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_type', 20); //polymorphic relation
            $table->unsignedBigInteger('pid')->nullable();
            $table->unsignedBigInteger('user_id'); //Creator            
            $table->integer('doc_source'); //ENUM
            $table->timestamps();            
            
            $table->string ('name', 255);            
            $table->date   ('issue_date')->nullable();
            $table->boolean('deleted')->default(0);
            $table->boolean('active')->default(1);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pid')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document');
    }
}
