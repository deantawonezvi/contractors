<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\Organisation;
use App\SubContractor;
use App\Tender;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'organisation'){

        $organisation = Organisation::where('id','=', Auth::user()->organisation_id )
                                    ->get();
        $tender = Tender::where('organisation_id','=', Auth::user()->organisation_id )
                                    ->with('tenderType')
                                    ->get();
            return view('home.organisation',['organisation'=>$organisation,
                'tenders'=>$tender]);
        }

        $sub_contractor = SubContractor::where('id','=', Auth::user()->sub_contractor_id )
            ->get();
        $tender = BillOfQuantity::where('sub_contractor_id','=', Auth::user()->sub_contractor_id )
            ->with('tender.organisation')
            ->get();
        return view('home.sub_contractor',['sub_contractor'=>$sub_contractor,
                                                'bids'=>$tender]);
    }
}
