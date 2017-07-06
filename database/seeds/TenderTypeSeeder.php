<?php

use App\TenderType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tender_types')->delete();

        TenderType::create(array('id' => 1,
            'name' => 'Request for Quotation(RFQ)', 'description' => 'project-1'

        ));

        TenderType::create(array('id' => 2,
            'name' => 'Request for Proposal(RFP)', 'description' => 'project-2'

        ));


        TenderType::create(array('id' => 3,
            'name' => 'Invitation to Tender(ITT)', 'description' => 'project-3'

        ));


        TenderType::create(array('id' => 4,
            'name' => 'Request for Vendor Qualification (RFVQ)', 'description' => 'project-3'

        ));


        TenderType::create(array('id' => 5,
            'name' => 'Request for Information(RFI)', 'description' => 'project-3'

        ));

        TenderType::create(array('id' => 6,
            'name' => 'Expression of Interest(EOI)', 'description' => 'project-3'

        ));

    }
}
