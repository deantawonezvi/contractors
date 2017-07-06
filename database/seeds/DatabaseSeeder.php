<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        $this->call(BusinessTypeSeeder::class);
        $this->call(OrganisationSeeder::class);
        $this->call(TenderTypeSeeder::class);
        $this->call(TenderSeeder::class);
        $this->call(SubContractorSeeder::class);

        $this->call(UsersTableSeeder::class);

    }
}
