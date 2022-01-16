<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

use App\Http\Enums\DocSourceType;
use App\Http\Enums\DocPartyType;

class documentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add documents
        Schema::disableForeignKeyConstraints();        
        DB::table('documents')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('documents')->insert([
            'doc_type'  => 'doc_receipt', //POLYMORPHIC TYPE
            'pid'       => NULL,
            'user_id'   => 1,
            'doc_source'=> DocSourceType::USR,
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'name'      => 'Bloček 1 - aktívny',
            'issue_date'=> date("Y-m-d"),
            // 'deleted'   => 0, //Default value
            // 'active'    => 1  //Default value
        ]);

        DB::table('documents')->insert([
            'doc_type'  => 'doc_receipt', //POLYMORPHIC TYPE
            'pid'       => NULL,
            'user_id'   => 1,
            'doc_source'=> DocSourceType::USR,
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'name'      => 'Bloček 2 - zmazaný',
            'issue_date'=> date("Y-m-d"),
            'deleted'   => 1,  //Default value = 0
            'active'    => 0   //Default value = 1
        ]);

        DB::table('documents')->insert([
            'doc_type'  => 'doc_receipt', //POLYMORPHIC TYPE
            'pid'       => NULL,
            'user_id'   => 1,
            'doc_source'=> DocSourceType::USR,
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'name'      => 'Bloček 3 - neaktívny',
            'issue_date'=> date("Y-m-d"),
            //'deleted'   => 0,  //Default value = 0
            'active'    => 0   //Default value = 1
        ]);



        //Attach some tags
        Schema::disableForeignKeyConstraints();        
        DB::table('document_tag')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('document_tag')->insert([
            'document_id' => 1,
            'tag_id' => 2
        ]);

        DB::table('document_tag')->insert([
            'document_id' => 3,
            'tag_id' => 2
        ]);

        DB::table('document_tag')->insert([
            'document_id' => 3,
            'tag_id' => 3
        ]);

        

        //Add some parties
        Schema::disableForeignKeyConstraints();        
        DB::table('doc_parties')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('doc_parties')->insert([
            'document_id' => 1,
            'party_id' => 4,
            'party_type' => 'App\\User',
            'party_name' => DocPartyType::ISSUER
        ]);

        DB::table('doc_parties')->insert([
            'document_id' => 1,
            'party_id' => 1,
            'party_type' => 'App\\User',
            'party_name' => DocPartyType::PARTNER
        ]);

        DB::table('doc_parties')->insert([
            'document_id' => 2,
            'party_id' => 1,
            'party_type' => 'App\\Company',
            'party_name' => DocPartyType::ISSUER
        ]);

        DB::table('doc_parties')->insert([
            'document_id' => 2,
            'party_id' => 4,
            'party_type' => 'App\\User',
            'party_name' => DocPartyType::PARTNER
        ]);
    }
}
