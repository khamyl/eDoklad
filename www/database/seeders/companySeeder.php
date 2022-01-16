<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

use App\Http\Enums\CmpInfoSourceType;

class companySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();  
        DB::table('companies')->truncate();
        Schema::enableForeignKeyConstraints();  
        
        DB::table('companies')->insert([
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'source_type' => CmpInfoSourceType::USR,
            'pid_source' => NULL,
            'name' => 'HEGDAG, s.r.o.' ,
            'cin' => 36464724,
            'tin' => 2020003975,
            'ctin' => 'SK2020003975',
            'address' => 'Obchodná 3 064 01 Stará Ľubovňa'                                   
        ]);

        DB::table('companies')->insert([
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'source_type' => CmpInfoSourceType::USR,
            'pid_source' => NULL,
            'name' => 'MOONLINE s.r.o.',
            'cin' => 44141734,
            'tin' => 2022647363,
            'ctin' => 'SK7120000195b',
            'address' => 'Moldavská cesta 8/A 040 11 Košice'                   
        ]);

        DB::table('companies')->insert([
            'created_at'=> date("Y-m-d H:i:s"),
            'updated_at'=> date("Y-m-d H:i:s"),
            'source_type' => CmpInfoSourceType::USR,
            'pid_source' => NULL,
            'name' => 'Kaufland Slovenská republika v.o.s.',
            'cin' => 35790164,
            'tin' => 2020234216,
            'ctin' => 'SK2020234216',
            'address' => 'Trnavská cesta 41/A 831 04 Bratislava'                        
        ]);

    }
}
