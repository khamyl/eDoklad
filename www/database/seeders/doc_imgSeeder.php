<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class doc_imgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doc_img')->truncate();

        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2018_12_181545167422.jpg', 'doc_img'=>2, 'user'=>4]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'3_2019_01_121547311151.jpg', 'doc_img'=>3, 'user'=>3]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2019_01_161547658542.jpg', 'doc_img'=>4, 'user'=>4]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2019_01_171547754954.jpg', 'doc_img'=>5, 'user'=>4]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2019_01_171547755031.jpg', 'doc_img'=>6, 'user'=>4]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2019_01_171547755193.jpg', 'doc_img'=>7, 'user'=>4]);
        DB::table('doc_img')->insert(['url'=>NULL, 'name'=>'4_2019_01_171547755962.jpg', 'doc_img'=>8, 'user'=>4]);
    }
}
