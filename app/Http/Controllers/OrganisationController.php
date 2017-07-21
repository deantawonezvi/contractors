<?php

namespace App\Http\Controllers;

use App\Organisation;
use App\SubContractor;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{

    public function getAllOrganisations(Request $request)
    {
        return Organisation::get();
    }
    public function getAllSubContractors(Request $request)
    {
        return SubContractor::get();
    }

}
