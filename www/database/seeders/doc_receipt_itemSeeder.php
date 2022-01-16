<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class doc_receipt_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        Schema::disableForeignKeyConstraints(); 
        DB::table('doc_receipt_items')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 1, 'name' => 'Položka 1', 'quantity' => 2, 'price' => 1210, 'price_no_vat' => 1000, 'vat' => 21]);
        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 1, 'name' => 'Položka 2', 'quantity' => 1, 'price' => 2100, 'price_no_vat' => 2000, 'vat' =>  5]);
        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 1, 'name' => 'Položka 3', 'quantity' => 5, 'price' => 3630, 'price_no_vat' => 3000, 'vat' => 21]);
        
        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 2, 'name' => 'Položka 1', 'quantity' => 1, 'price' => 1210, 'price_no_vat' => 1000, 'vat' => 21]);
        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 2, 'name' => 'Položka 2', 'quantity' => 1, 'price' => 1210, 'price_no_vat' => 1000, 'vat' => 21]);
        DB::table('doc_receipt_items')->insert(['doc_receipt_id' => 2, 'name' => 'Položka 3', 'quantity' => 2, 'price' => 1210, 'price_no_vat' => 1000, 'vat' => 21]);
    }
}
