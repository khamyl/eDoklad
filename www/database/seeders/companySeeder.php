<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class companySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->truncate();
        
        DB::table('company')->insert([
            'ico' => 36464724,
            'dic' => 2020003975,
            'ic_dph' => 'SK2020003975',
            'address' => 'Obchodná 3 064 01 Stará Ľubovňa',
            'name' => 'HEGDAG, s.r.o.'
        ]);

        DB::table('company')->insert([
            'ico' => 44141734,
            'dic' => 2022647363,
            'ic_dph' => 'SK7120000195b',
            'address' => 'Moldavská cesta 8/A 040 11 Košice',
            'name' => 'MOONLINE s.r.o.'
        ]);

        DB::table('company')->insert([
            'ico' => 35790164,
            'dic' => 2020234216,
            'ic_dph' => 'SK2020234216',
            'address' => 'Trnavská cesta 41/A 831 04 Bratislava',
            'name' => 'Kaufland Slovenská republika v.o.s.'
        ]);

    }
}
