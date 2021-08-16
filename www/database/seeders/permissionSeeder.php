<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App;
use DB;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        
        App\Permission::create([            
            'slug' => 'app_edit_user',
            'description' => 'Can create or edit user on app level'
        ]);

        App\Permission::create([            
            'slug' => 'com_edit_user',
            'description' => 'Can create or edit user on company level'
        ]);

        App\Permission::create([            
            'slug' => 'com_edit_docs',
            'description' => 'Can create or edit documents on company level'
        ]);

        App\Permission::create([            
            'slug' => 'com_read_docs',
            'description' => 'Can read documents on company level'
        ]);

        App\Permission::create([            
            'slug' => 'acc_read_docs',
            'description' => 'Can read documents on accountant profile level'
        ]);
    }
}
