<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class documentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('document')->truncate();

        DB::table('document')->insert([
            'owner'=>3, 
            'edit_id'=>3, 
            'real_id'=>3, 
            'name'=>'Dokument2019-01-12',  
            'type'=>1, 
            'date'=>'2019-01-12',  
            'doc_img'=>3, 
            'tag'=>NULL, 
            'tag_color'=>NULL, 
            'active'=>0,
            'tag_ucto'=>NULL, 
            'tag_color_ucto'=>NULL            
        ]);

        DB::table('document')->insert([
            'owner'=>4, 
            'edit_id'=>4, 
            'real_id'=>4, 
            'name'=>'Dokument2019-01-16',  
            'type'=>1, 
            'date'=>'2019-01-16',  
            'doc_img'=>4, 
            'tag'=>'nieco', 
            'tag_color'=>'4FFFBB', 
            'active'=>1,
            'tag_ucto'=>NULL, 
            'tag_color_ucto'=>NULL            
        ]);
    }
}
