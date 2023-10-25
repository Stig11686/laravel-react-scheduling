<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funder;

class FundersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $funders = [
            ['name' => 'Serco', 'code' => 'serco'],
            ['name' => 'York & North Yorkshire', 'code' => 'YNY'],
            ['name' => 'Sheffield College', 'code' => 'SHEFF'],
            ['name' => 'West Yorkshire Combined Authorities', 'code' => 'WYCA']
        ];

        foreach($funders as $funder){
            Funder::create($funder);
        }
    }
}
