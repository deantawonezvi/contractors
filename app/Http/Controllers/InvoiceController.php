<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\Invoice;
use App\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{

    public function uploadInvoice(Request $request){
        Validator::make($request->all(), [
            'invoice' => 'required | file | unique:invoices,name',
        ])->validate();

        $tender = Tender::find($request->tender_id);

        $file = $request->file('invoice');
        $ext = $file->guessClientExtension();
        $name = $file->getClientOriginalName();
        $file->storeAs("public/invoices/$request->tender_id", $name);

        Tender::where('id','=',$request->tender_id)
            ->update(['status'=>'Job approved. Invoice Submitted']);
        BillOfQuantity::where('tender_id','=',$request->tender_id)
            ->update(['status'=>'Job approved. Invoice Submitted']);

        Invoice::create([
            'name' => $name,
            'tender_id' => $request->tender_id,
            'file' => "storage/invoices/$request->tender_id/$name"
        ]);



        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $invoices = Invoice::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->home()->with([
            'success'=>'Invoice Upload Successful!',
            'bids' => $bids,
            'tender' => $tender,
            'invoices' => $invoices
        ]);
    }

    public function deleteInvoice(Request $request){
        Invoice::destroy($request->id);
        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $invoices = Invoice::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->home()->with([
            'warning'=>'Purchase Order Deleted!',
            'bids' => $bids,
            'tender' => $tender,
            'invoices' => $invoices
        ]);
    }

    
}
