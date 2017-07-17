<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\PurchaseOrder;
use App\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function uploadPurchaseOrder(Request $request)
    {
        Validator::make($request->all(), [
            'purchase_order' => 'required | file | unique:purchase_orders,name',
        ])->validate();

        $tender = Tender::find($request->tender_id);

        $file = $request->file('purchase_order');
        $ext = $file->guessClientExtension();
        $name = $file->getClientOriginalName();
        $file->storeAs("public/purchase_orders/$request->tender_id", $name);

        PurchaseOrder::create([
            'name' => $name,
            'tender_id' => $request->tender_id,
            'file' => "storage/purchase_orders/$request->tender_id/$name"
        ]);

        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $purchase_orders = PurchaseOrder::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->back()->with([
                'info'=>'Purchase Order Upload Successful!',
                'bids' => $bids,
                'tender' => $tender,
                'purchase_orders' => $purchase_orders
            ]);
    }

    public function deletePurchaseOrder(Request $request)
    {
        PurchaseOrder::destroy($request->id);
        $tender = Tender::find($request->tender_id);

        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $purchase_orders = PurchaseOrder::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->back()->with([
                'warning'=>'Purchase Order Deleted!',
                'bids' => $bids,
                'tender' => $tender,
                'purchase_orders' => $purchase_orders
            ]);
    }
}
