<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(usersSeeder::class);
        $this->call(password_resetSeeder::class);
        $this->call(permissionSeeder::class);
        $this->call(roleSeeder::class);

        // $this->call(rel_user_userSeeder::class);        
        // $this->call(companySeeder::class);
        // $this->call(edit_documentSeeder::class);
        // $this->call(edit_itemSeeder::class);
        // $this->call(real_documentSeeder::class);
        // $this->call(real_itemSeeder::class);
        // $this->call(documentSeeder::class);
        // $this->call(doc_imgSeeder::class);      
        // $this->call(tagSeeder::class);
    }
}
