<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class doc_receiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        Schema::disableForeignKeyConstraints(); 
        DB::table('doc_receipts')->truncate(); 
        Schema::enableForeignKeyConstraints();              

        DB::table('doc_receipts')->insert([            
            'document_id' => 1,
            'sum' => 1230,
            'sum_no_vat' =>  1110,
            'vat' => 12
        ]);

        DB::table('doc_receipts')->insert([            
            'document_id' => 2,
            'sum' => 2460,
            'sum_no_vat' =>  2220,
            'vat' => 24
        ]);   
        
        DB::table('doc_receipts')->insert([            
            'document_id' => 3,
            'sum' => 2460,
            'sum_no_vat' =>  2220,
            'vat' => 24
        ]); 
    }
}
