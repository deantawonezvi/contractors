<?php

namespace App\Http\Controllers;

use App\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $tenders = Tender::with('organisation.businessType','tenderType')->paginate(25);

        return $tenders;
    }

    public function show($tender){
        $selected_tender =  Tender::with('tenderType', 'organisation')
            ->find($tender);

        return view('tender.view', ['tender'=>$selected_tender]);
    }


}
