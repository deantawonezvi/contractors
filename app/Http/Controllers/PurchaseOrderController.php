<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    public function uploadPurchaseOrder(Request $request){
        Validator::make($request->all(), [
            'purchase_order' => 'required | file',
        ])->validate();


    }
}
