<?php

use Illuminate\Database\Seeder;

class TenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i =0; $i<100; $i++){
            \App\Tender::create([
                'name' => $faker->company,
                'business_type_id' => $faker->numberBetween(1, 3),
                'tender_type_id' => $faker->numberBetween(1, 5),
                'organisation_id' => $faker->numberBetween(1, 20),
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'instructions' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'published_at' => \Carbon\Carbon::now()->addDays(5),
                'closing_at' => \Carbon\Carbon::now()->addDays(10),
            ]);
        }

    }
}
