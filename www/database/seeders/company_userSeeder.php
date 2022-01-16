<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

use App\Http\Enums\UsrRoleInCmp;

class company_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_user')->truncate();
        
        DB::table('company_user')->insert([
            'company_id' => 1,
            'user_id' => 1,
            'role' => UsrRoleInCmp::BOARD_CHAIRMAN           
        ]);

        DB::table('company_user')->insert([
            'company_id' => 1,
            'user_id' => 2,
            'role' => UsrRoleInCmp::EMPLOYEE            
        ]);

        DB::table('company_user')->insert([
            'company_id' => 1,
            'user_id' => 3,
            'role' => UsrRoleInCmp::ACCOUNTANT         
        ]);
    }
}
