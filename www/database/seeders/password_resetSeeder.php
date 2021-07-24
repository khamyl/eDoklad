<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class password_resetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('password_resets')->truncate();

        DB::table('password_resets')->insert([
            'email' => 'erko185@gmail.com',
            'token' => '$2y$10$BT5Sp0nHH0dlKUNkeuLs9uwXZDSJ7LzA43BiHzg3O0DIolrdiC3F2',
            'created_at' => '2018-10-28 10:44:28'
            ]);
    }
}
