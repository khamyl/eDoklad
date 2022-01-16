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
        // Users and Permissions
        $this->call(usersSeeder::class);
        $this->call(password_resetSeeder::class);
        $this->call(permissionSeeder::class);
        $this->call(roleSeeder::class);

        //Documents
        $this->call(companySeeder::class);
        $this->call(company_userSeeder::class);  
        $this->call(tagSeeder::class);
        $this->call(documentSeeder::class);
        $this->call(doc_receiptSeeder::class);
        $this->call(doc_receipt_itemSeeder::class);
              
                     
        
        //$this->call(doc_imgSeeder::class); 
    }
}
