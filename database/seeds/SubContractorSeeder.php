<?php

use Illuminate\Database\Seeder;

class SubContractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i =0; $i<20; $i++){
            \App\SubContractor::create([
                'name' => $faker->company,
                'business_type_id' => $faker->numberBetween(1, 3),
                'address' => $faker->address,
                'email' => $faker->companyEmail,
                'mobile' => $faker->numberBetween(263772000000,263779999999),
                'telephone'=>$faker->numberBetween(240291,29999)
            ]);
        }

    }
}
