<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App;
use DB;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        App\User::create([            
            'email'             => 'erko185@gmail.com',
            'email_verified_at' => NULL,
            'password'          => '$2y$10$INy94sHZrf4zjQVTaTcnie5S/NHP5EzeOmJOr84tBv2DKbFLbK0U6',
            'remember_token'    => 'olkWjpIAePoenDWwWwNognZCq1Op7rZeQtFB00GqT888NkOgwMypxL1yeJNi',
            'name'              => 'erik',
            'surname'           => 'bohony' ,
            'acc_code'         => '10erbo79',
        ]);

        App\User::create([
            'email'               => 'marek@marek.sk', 
            'email_verified_at'   => NULL, 
            'password'            => '$2y$10$WGJKdUvi3FtR4mPbTuLBhOX5El/A3EnTOXqa0C0IQoriPmAEkt3HW', 
            'remember_token'      => '8yICnyAgCNjIj0TLMkTQAFm6Vi2i6cPRP6H2D1bz7BOzrMu4H4GMyf8JgCgp', 
            'name'                => 'marek', 
            'surname'             => 'marek', 
            'acc_code'           => NULL, 
        ]);

        App\User::create([
            'email'               => 'pokus@pokus.sk',
            'email_verified_at'   => NULL,
            'password'            => '$2y$10$WOUGnhoRuG0mVta0l9jJb.TmUjKpbGHfqK6wfmx1ORhS4zUBd7Qoy', 
            'remember_token'      => 'JJFmFRUWOkgfKLedQ5aE2P7jDd9sE63x69th8POCPxjvB30jjnLPv8FiyR0I', 
            'name'                => 'pokus',
            'surname'             => 'pokus',
            'acc_code'           => '3popo78',
        ]);

        App\User::create([
            'email'               => 'feri@feri.sk',
            'email_verified_at'   => NULL,
            'password'            => '$2y$10$7EhTS2evbRNKpvbL9oy9qe4pNNt4eY2oHE3wTJ1r0rsvtSbYC1uD2',
            'remember_token'      => 'kQnQIZe73WYVvu5LlmnagAcUAFnNlrOyk1rgXrSHujYmIhVbeBneyPQ8gLVf',
            'name'                => 'feri',
            'surname'             => 'feri',
            'acc_code'           => '4fefe35',
        ]);

    }
}
