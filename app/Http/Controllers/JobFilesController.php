<?php

namespace App\Http\Controllers;

use App\BillOfQuantity;
use App\JobFiles;
use App\Organisation;
use App\PurchaseOrder;
use App\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobFilesController extends Controller
{
    public function approveJob(Request $request)
    {
        $organisation = Organisation::where('id','=', Auth::user()->organisation_id )
            ->get();
        $tender = Tender::where('organisation_id','=', Auth::user()->organisation_id )
            ->with('tenderType')
            ->get();
        if ($request->approve == 'yes') {
            JobFiles::where('tender_id', '=', $request->tender_id)
                ->update(['status' => 'Job Approved',
                    'description' => $request->comment]);
            Tender::where('id','=',$request->tender_id)
                ->update(['status'=>'Job approved. Awaiting Invoice Submission']);
            BillOfQuantity::where('tender_id','=',$request->tender_id)
                ->update(['status'=>'Job approved. Awaiting Invoice Submission']);


            if ($tender[0]->organisation_id != Auth::user()->organisation_id) {
                abort(404);
            }

            return redirect()->back()->with([
                'success' => 'Job Approval has been sent to the Sub Contractor!',

                'organisation' => $organisation,
                'tender' => $tender,

            ]);

        }

        Validator::make($request->all(), [
            'comment' => 'required',
        ])->validate();
        JobFiles::where('tender_id', '=', $request->tender_id)
            ->update(['description' => $request->comment]);
        return redirect()->back()->with([
            'warning' => 'Your comments have been sent to the Sub Contractor!',
            'organisation' => $organisation,
            'tender' => $tender,
        ]);

    }


    public function uploadJobFile(Request $request)
    {
        Validator::make($request->all(), [
            'job_file' => 'required | file | unique:job_files,name',
        ])->validate();


        $file = $request->file('job_file');
        $ext = $file->guessClientExtension();
        $name = $file->getClientOriginalName();
        $file->storeAs("public/job_files/$request->tender_id", $name);

        JobFiles::create([
            'name' => $name,
            'tender_id' => $request->tender_id,
            'file' => "storage/job_files/$request->tender_id/$name"
        ]);

        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor', 'organisation')
            ->get();

        $purchase_orders = PurchaseOrder::where('tender_id', '=', $request->tender_id)
            ->get();
        $job_files = JobFiles::where('tender_id', '=', $request->id)
            ->get();

        return redirect()->home()->with([
            'info' => 'Job File Upload Successful!',
            'bids' => $bids,
            'tender' => $tender,
            'purchase_orders' => $purchase_orders,
            'job_files' => $job_files,

        ]);
    }

    public function deleteJobFile(Request $request)
    {
        JobFiles::destroy($request->id);
        $tender = Tender::find($request->tender_id);

        $bids = BillOfQuantity::where('tender_id', '=', $request->tender_id)
            ->with('SubContractor')
            ->get();
        $tender = Tender::where('id', '=', $request->tender_id)
            ->with('tenderType', 'billOfQuantities.subContractor')
            ->get();
        $job_files = JobFiles::where('tender_id', '=', $request->tender_id)
            ->get();
        return redirect()->home()->with([
            'warning' => 'Job File Deleted!',
            'bids' => $bids,
            'tender' => $tender,
            'job_files' => $job_files
        ]);
    }
}
