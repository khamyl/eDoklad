<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class edit_documentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('edit_document')->truncate();

        DB::table('edit_document')->insert([            
            'company_name' => 'Kaufland Slovenská republika v.o.s.',
            'company_address' => 'Trnavská cesta 41/A 831 04 Bratislava',
            'ico' => 35790164,
            'dph' => 0,
            'ic_dph' => 'SK2020234216',
            'summar' => '7.81',
            'edit_id' => 3,
            'date' => '2018-10-01',
            'time' => '13:04:14',
            'dpk' => '50020202342161620',
            'pay'=> 0            
        ]);

        DB::table('edit_document')->insert([            
            'company_name' => 'Kaufland Slovenská republika v.o.s.',
            'company_address' => 'Trnavská cesta 41/A 831 04 Bratislava',
            'ico' => 35790164,
            'dph' => 0,
            'ic_dph' => 'SK2020234216',
            'summar' => '7.81',
            'edit_id' => 4,
            'date' => '2018-10-01',
            'time' => '13:04:14',
            'dpk' => '50020202342161620',
            'pay'=> 0            
        ]);
    }
}
