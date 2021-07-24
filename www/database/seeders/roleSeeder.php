<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App;
use DB;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        App\Role::create([            
            'slug' => 'super_admin',
            'description' => 'Role with no access limitation - used esspecially by testers or developers.'
        ]);

        App\Role::create([            
            'slug' => 'company_owner',
            'description' => 'User who registered a company - with no limitations within the company profile'
        ]);

        App\Role::create([            
            'slug' => 'main_accountant',
            'description' => 'User - accoutant with no limitations within the accoutant profile'
        ]);
    }
}
