<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
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

        if(Auth::user()->role == 'sub_contractor'){
            abort(404);
        }
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

    public function viewTenderDetails(Request $request){
        $bids = BillOfQuantity::where('tender_id','=',$request->id)
                                ->with('SubContractor')
                                ->get();
        $tender = Tender::where('id','=',$request->id)
                                ->with('tenderType')
                                ->get();
        return view('tender.details', ['bids'=>$bids,
                                            'tender'=>$tender]);
    }

    public function approveTender(Request $request){

        Tender::find($request->tender_id)
                ->update(array('status'=>'approved',
                                'bill_of_quantities_id'=>$request->boq_id));

        return redirect()->back()->with('info', 'Tender Created Successfully!');

    }

    public function viewBidTender(Request $request){

        if(Auth::user()->role == 'organisation'){
            abort(404);
        }
        Tender::find($request->tender_id)
                ->update(array('status'=>'approved',
                                'bill_of_quantities_id'=>$request->boq_id));

        return redirect()->back()->with('info', 'Approval Successful. The SubContractor will be notified immediately!');

    }


}
