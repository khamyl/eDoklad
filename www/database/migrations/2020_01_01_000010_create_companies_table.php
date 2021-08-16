<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_type_id');
            $table->timestamps();           
            
            $table->string ('name');
            $table->integer('cin'); //ICO
            $table->integer('tin')->nullable(); //DIC
            $table->string ('ctin', 25)->nullable(); //IC DPH
            $table->string ('address', 255)->nullable();  
            
            $table->foreign('source_type_id')->references('id')->on('source_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
