<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class real_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('real_item')->truncate();

        DB::table('real_item')->insert(['name' => 'Položka', 'price' => 15.2, 'quantity' => 5, 'real_id' => 3]);
        DB::table('real_item')->insert(['name' => 'Položka', 'price' => 15.2, 'quantity' => 5, 'real_id' => 4]);
    }
}
