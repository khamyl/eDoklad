<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        DB::table('tag')->truncate();

        DB::table('tag')->insert(['tag' => 'halvne', 'color' => '3B8CFF', 'description' => NULL, 'rel_tag_user' => 4]);
        DB::table('tag')->insert(['tag' => 'halvne', 'color' => '4FFFBB', 'description' => NULL, 'rel_tag_user' => 4]);
        DB::table('tag')->insert(['tag' => 'sadasd', 'color' => '000000', 'description' => NULL, 'rel_tag_user' => 2]);
        DB::table('tag')->insert(['tag' => 'sss',    'color' => 'CF41FF', 'description' =>'sss', 'rel_tag_user' => 4]);
    }
}
