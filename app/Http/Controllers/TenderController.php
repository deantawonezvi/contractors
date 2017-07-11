<?php

namespace App\Http\Controllers;

use App\BusinessType;
use App\Tender;
use App\TenderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function create(){
        $tenderTypes = TenderType::all();
        $businessTypes = BusinessType::all();
        return view('tender.create', ['tenderTypes'=>$tenderTypes, 'businessTypes'=>$businessTypes]);
    }

    public function show($tender){
        $selected_tender =  Tender::with('tenderType', 'organisation')
            ->find($tender);

        return view('tender.view', ['tender'=>$selected_tender]);
    }

    public function store(Request $request){

        Validator::make($request->all(), [
            'name' => 'required',
            'tender_type_id' => 'required|exists:tender_types,id',
            'business_type_id' => 'required|exists:business_types,id',
            'description' => 'required',
            'instructions' => 'required',
        ])->validate();

        $values = $request->except('_token');
        $values['organisation_id'] = Auth::user()->organisation_id;

        Tender::create($values);

        return redirect()->back()->with('info', 'Tender Created Successfully!');

    }

    public function destroy($id){

        if(Tender::destroy($id)){
            return array('code'=>0, 'description'=>'Tender deleted');
        }else{
            return array('code'=>1, 'description'=>'Operation failed');
        }
    }

    public function edit($id, Request $request){

        return Tender::find($id)->update($request->except('_token'));

    }

}
