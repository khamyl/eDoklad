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
            $table->integer('source_type');
            $table->unsignedBigInteger('pid_source')->nullable();
            $table->timestamps();           
            
            $table->string ('name');
            $table->integer('cin'); //ICO
            $table->integer('tin')->nullable(); //DIC
            $table->string ('ctin', 25)->nullable(); //IC DPH
            $table->string ('address', 255)->nullable();  
            
            $table->foreign('pid_source')->references('id')->on('companies');
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
