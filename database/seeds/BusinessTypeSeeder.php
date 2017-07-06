<?php

use App\BusinessType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_types')->delete();

        BusinessType::create([
            'id' => 1,
            'name' => 'Construction',
            'description' => 'Construction'
        ]);

        BusinessType::create([
            'id' => 2,
            'name' => 'Transportation',
            'description' => 'Transportation'
        ]);

        BusinessType::create([
            'id' => 3,
            'name' => 'Information Technology',
            'description' => 'Information Technology'
        ]);
    }


}
