<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean   ('active')->default(1);
            $table->string    ('email')->unique();
            $table->timestamp ('email_verified_at')->nullable();
            $table->string    ('password');
            $table->rememberToken(); 
            $table->string    ('name')->nullable();                       
            $table->string    ('surname', 255)->nullable();
            $table->string    ('acc_code', 50)->nullable();  //code for accountant
            $table->boolean   ('deleted')->default(0);        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
