<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class edit_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('edit_item')->truncate();

        DB::table('edit_item')->insert(['name' => 'Položka', 'price' => 15.2, 'quantity' => 5, 'edit_id' => 3]);
        DB::table('edit_item')->insert(['name' => 'Položka', 'price' => 15.2, 'quantity' => 5, 'edit_id' => 4]);
    }
}
