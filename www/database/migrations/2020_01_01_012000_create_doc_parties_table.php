<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_parties', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('party_id'); //Polymorphic ID
            $table->string('party_type'); //Polymorphic TYPE
            $table->integer('party_name'); //ENUM 

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            
            // Khamyl: This is not possible for polymorphic relations 
            // $table->foreign('party_id', 'doc_parties_party_id_foreign_user')->references('id')->on('users');
            // $table->foreign('party_id', 'doc_parties_party_id_foreign_company')->references('id')->on('companies');

            $table->primary(['document_id','party_id', 'party_type']);         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_parties');
    }
}
