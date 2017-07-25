<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\BusinessType;
use App\Invoice;
use App\JobFiles;
use App\PurchaseOrder;
use App\SubContractor;
use App\Tender;
use App\TenderType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TenderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $tenders = Tender::with('organisation.businessType', 'tenderType')
            ->where('status', '=', 'pending')
            ->paginate(25);

        return $tenders;
    }

    public function create()
    {

        if (Auth::user()->role == 'sub_contractor') {
            abort(404);
        }
        $tenderTypes = TenderType::all();
        $businessTypes = BusinessType::all();
        return view('tender.create', ['tenderTypes' => $tenderTypes, 'businessTypes' => $businessTypes]);
    }

    public function show($tender)
    {
        $selected_tender = Tender::with('tenderType', 'organisation')
            ->find($tender);

        return view('tender.view', ['tender' => $selected_tender]);
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'tender_type_id' => 'required|exists:tender_types,id',
            'business_type_id' => 'required|exists:business_types,id',
            'description' => 'required',
            'instructions' => 'required',
            'closing_date' => 'required'
        ])->validate();

        $values = $request->except('_token');
        $values = array(
            'name' => $request->name,
            'tender_type_id' => $request->tender_type_id,
            'business_type_id'=>$request->business_type_id,
            'description'=>$request->description,
            'instructions'=>$request->description,
            'closing_at'=>new Carbon($request->closing_date)
        );
        $values['organisation_id'] = Auth::user()->organisation_id;

        Tender::create($values);

        return redirect()->back()->with('info', 'Tender Created Successfully!');

    }

    public function destroy($id)
    {

        if (Tender::destroy($id)) {
            return array('code' => 0, 'description' => 'Tender deleted');
        } else {
            return array('code' => 1, 'description' => 'Operation failed');
        }
    }

    public function edit($id, Request $request)
    {

        return Tender::find($id)->update($request->except('_token'));

    }

    public function viewTenderDetails(Request $request)
    {

        $bids = BillOfQuantity::where('tender_id', '=', $request->id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $purchase_orders = PurchaseOrder::where('tender_id', '=', $request->id)
            ->get();
        $job_files = JobFiles::where('tender_id', '=', $request->id)
            ->get();
        $invoices = Invoice::where('tender_id', '=', $request->id)
            ->get();

        if ($tender[0]->organisation_id != Auth::user()->organisation_id) {
            abort(404);
        }
        return view('tender.details', [
            'bids' => $bids,
            'tender' => $tender,
            'purchase_orders' => $purchase_orders,
            'job_files' => $job_files,
            'invoices' => $invoices
        ]);
    }

    public function viewJobDetails(Request $request)
    {

        $bids = BillOfQuantity::where('tender_id', '=', $request->id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->id)
            ->with('tenderType', 'billOfQuantities.subContractor', 'organisation')
            ->get();
        $purchase_orders = PurchaseOrder::where('tender_id', '=', $request->id)
            ->get();
        $job_files = JobFiles::where('tender_id', '=', $request->id)
            ->get();

        if (json_decode($tender[0])->bill_of_quantities->sub_contractor->id != Auth::user()->sub_contractor_id) {
            abort(404);
        }
        return view('jobs.view', ['bids' => $bids,
            'tender' => $tender,
            'purchase_orders' => $purchase_orders,
            'job_files'=>$job_files
        ]);
    }

    public function declineJobDetails(Request $request)
    {

        BillOfQuantity::destroy($request->boq_id);
        Tender::where('id', '=', $request->tender_id)
            ->update(['status' => 'pending']);
        BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->update(['status' => 'pending']);
        PurchaseOrder::where('tender_id', '=', $request->tender_id)
            ->delete();

        $sub_contractor = SubContractor::where('id', '=', Auth::user()->sub_contractor_id)
            ->get();
        $tender = BillOfQuantity::where('sub_contractor_id', '=', Auth::user()->sub_contractor_id)
            ->with('tender.organisation')
            ->get();
        return view('home.sub_contractor', ['sub_contractor' => $sub_contractor,
            'bids' => $tender]);


    }

    public function approveTender(Request $request)
    {

        Tender::find($request->tender_id)
            ->update(array('status' => 'approved',
                'bill_of_quantities_id' => $request->boq_id));
        BillOfQuantity::find($request->boq_id)
            ->update(array('status' => 'approved'));
        BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->where('status', 'not like', 'approved')
            ->update(array('status' => 'declined'));


        return redirect()->back()->with('info', 'Bid Accepted Successfully. Sub Contractor will be notified immediately!');

    }

    public function viewBidTender(Request $request)
    {

        if (Auth::user()->role == 'organisation') {
            abort(404);
        }
        $selected_tender = Tender::with('tenderType', 'organisation')
            ->where('id', '=', $request->id)
            ->get();

        return view('tender.bid', ['tender' => $selected_tender]);

    }

    public function submitBidTender(Request $request)
    {

        if (Auth::user()->role == 'organisation') {
            abort(404);
        }
        Validator::make($request->all(), [
            'tender_id' => 'required|exists:tenders,id',
            'sub_contractor_id' => 'required|exists:sub_contractors,id',
            'boq' => 'required | file',
        ])->validate();

        $file = $request->file('boq');
        $name = $file->getClientOriginalName();
        $file->storeAs("public/boq/$request->tender_id", $name);
        BillOfQuantity::create([
            'tender_id' => $request->tender_id,
            'sub_contractor_id' => $request->sub_contractor_id,
            'file_name' => $name,
            'file' => "storage/boq/$request->tender_id/$name"
        ]);


        return redirect()->route('home')->with('info', 'Bid Successful!');
    }

    public function removeBidTender(Request $request)
    {
        BillOfQuantity::destroy($request->id);
        return redirect()->route('home')->with('info', 'Rejected Bid Removed!');
    }

    public function deleteTender(Request $request)
    {
        Tender::destroy($request->id);
        return redirect()->route('home')->with('warning', 'Tender Deleted!');
    }


}
