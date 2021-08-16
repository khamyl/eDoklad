<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class rel_user_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rel_user_user')->truncate();
        
        DB::table('rel_user_user')->insert(['user_id' => 4, 'ucto_id' => 2, 'rel_user_user' => 2]);
    }
}
