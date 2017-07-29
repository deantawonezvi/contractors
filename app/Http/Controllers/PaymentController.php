<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\Invoice;
use App\Payment;
use App\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function uploadPayment(Request $request){
        Validator::make($request->all(), [
            'payment' => 'required | file | unique:invoices,name',
        ])->validate();

        $tender = Tender::find($request->tender_id);

        $file = $request->file('payment');
        $ext = $file->guessClientExtension();
        $name = $file->getClientOriginalName();
        $file->storeAs("public/invoices/$request->tender_id", $name);

        Tender::where('id','=',$request->tender_id)
            ->update(['status'=>'Job Completed. Proof of Payment Submitted']);
        BillOfQuantity::where('tender_id','=',$request->tender_id)
            ->update(['status'=>'Job Completed. Proof of Payment Submitted']);

        Payment::create([
            'name' => $name,
            'tender_id' => $request->tender_id,
            'file' => "storage/payment/$request->tender_id/$name"
        ]);



        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $invoices = Invoice::where('tender_id', '=', $request->tender_id)
            ->get();
        $payments = Payment::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->home()->with([
            'success'=>'Proof of Payment Upload Successful!',
            'bids' => $bids,
            'tender' => $tender,
            'invoices' => $invoices,
            'payments' => $payments
        ]);
    }

    public function deletePayment(Request $request){
        Payment::destroy($request->id);
        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $invoices = Invoice::where('tender_id', '=', $request->tender_id)
            ->get();
        $payments = Payment::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->home()->with([
            'warning'=>'Proof of Payment Deleted!',
            'bids' => $bids,
            'tender' => $tender,
            'invoices' => $invoices,
            'payments' => $payments
        ]);
    }

}
