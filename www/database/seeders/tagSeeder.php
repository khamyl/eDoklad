<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class tagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();        
        DB::table('tags')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('tags')->insert(['tag' => 'contract',     'color' => '#3B8CFF', 'description' => NULL,     'user_id' => 4]);
        DB::table('tags')->insert(['tag' => 'receipt',      'color' => '#4FFFBB', 'description' => NULL,     'user_id' => 4]);
        DB::table('tags')->insert(['tag' => 'taxes',        'color' => '#000000', 'description' => NULL,     'user_id' => 2]);
        DB::table('tags')->insert(['tag' => 'certificate',  'color' => '#CF41FF', 'description' =>'Desc...', 'user_id' => 4]);
    }
}
