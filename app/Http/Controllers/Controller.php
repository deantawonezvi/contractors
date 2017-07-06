<?php

namespace App\Http\Controllers;

use App\Tender;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function welcome(TenderController $tendersController){

        $availableTenderTypes = Tender::groupBy('tender_type_id')->with('tenderType')->get(['tender_type_id']);
        $availableBusinessTypes = Tender::groupBy('business_type_id')->with('businessType')->get(['business_type_id']);

        return view('welcome',[
            'tenders'=>$tendersController->index(),
            'tenderTypes'=>$availableTenderTypes,
            'businessTypes'=>$availableBusinessTypes,
        ]);
    }

    public function search(Request $request, TenderController $tendersController)
    {
        Validator::make($request->all(), [
            'category'=>'numeric',
            'tender_type'=>'numeric',
        ])->validate();

        if($request->category){
            if($request->tender_type){
                $tenders = Tender::whereTenderTypeId($request->tender_type)
                    ->whereBusinessTypeId($request->category)
                    ->with('tenderType', 'organisation')
                    ->simplePaginate(250);
            }
            else{
                $tenders = Tender::whereBusinessTypeId($request->category)
                    ->with('tenderType', 'organisation')
                    ->simplePaginate(250);
            }
        }

        if($request->tender_type){
            $tenders = Tender::whereTenderTypeId($request->tender_type)
                ->with('tenderType', 'organisation')
                ->simplePaginate(250);
        }else{
            $tenders = $tendersController->index();
        }


        $availableTenderTypes = Tender::groupBy('tender_type_id')->with('tenderType')->get(['tender_type_id']);
        $availableBusinessTypes = Tender::groupBy('business_type_id')->with('businessType')->get(['business_type_id']);


        return view('welcome',[
            'tenders'=>$tenders,
            'tenderTypes'=>$availableTenderTypes,
            'businessTypes'=>$availableBusinessTypes,
        ]);
    }
}
