@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="banner shadow-1" style="margin-top: 50px;">
            <h2>
                <a class="cyan-text" href="/home"><i class="fa fa-home"></i> Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Tender</span>
                <i class="fa fa-angle-right"></i>
                <a class="cyan-text" href="#">{{$tender[0]->name}}</a>
                @if( $tender[0]->status == 'pending')
                    <i class="fa fa-angle-right"></i>
                    <span>Current Bids</span>
                @elseif($tender[0]->status == 'approved')
                    <i class="fa fa-angle-right"></i>
                    <span>Job Details</span>
                @endif
            </h2>
        </div>
        <br>
        <hr class="divider-icon">
        @include('partials.info')
        @include('partials.error')
        @if($tender[0]->status == 'approved')
            <center>
                <h2 class="cyan-text">
                    JOB DETAILS
                </h2>
            </center>
            <br>

            @if($purchase_orders[0]->status == 'pending')
                <form action="{{url('/tender/job/decline')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="tender_id" value="{{$tender[0]->id}}">
                    <input type="hidden" name="boq_id" value="{{$tender[0]->bill_of_quantities_id}}">
                    <button class="btn btn-flat red white-text">
                        DECLINE JOB
                    </button>
                </form>
            @endif

            <br><br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2>ORGANISATION INFORMATION
                    </h2>
                </div>
                <br><br>
                Name : {{json_decode($tender[0])->organisation->name}}<br>
                Address : {{json_decode($tender[0])->organisation->address}}<br>
                Email : {{json_decode($tender[0])->organisation->email}}<br>
                Mobile : {{json_decode($tender[0])->organisation->mobile}}
            </div>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> APPROVED BOQ
                    </h2>
                </div>
                <br><br>

                <a href="{{asset(json_decode($tender[0])->bill_of_quantities->file)}}"
                   target="_self">{{json_decode($tender[0])->bill_of_quantities->file_name}}</a>
                <br>
                <div class="hidden">{{$tender_id = $tender[0]->id }}</div>
            </div>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> PURCHASE ORDERS
                    </h2>
                </div>
                <br>
                <h3>
                    UPLOADED PURCHASE ORDERS
                </h3>
                <br>
                @foreach($purchase_orders as $purchase_order)
                    <a href="{{asset($purchase_order->file)}}" target="_self">{{$purchase_order->name}}</a><br>
                @endforeach
            </div>
            <br>
            <br>
            @if(sizeof($job_files) !=0)
                <div class="card card-default card-body">
                    <div class="card-header">
                        <h2>JOB STATUS - {{ucfirst($job_files[0]->status)}}</h2>
                    </div>
                    <br>
                    @if($job_files[0]->description)
                    Comment - {{$job_files[0]->description}}
                    @endif
                </div>
            @endif

            <br>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> JOB DOCUMENTS
                    </h2>
                </div>
                <br>
                <h3>
                    UPLOADED JOB DOCUMENTS
                </h3>
                <br>
                @foreach($job_files as $job_file)
                    <a href="{{asset($job_file->file)}}" target="_self">{{$job_file->name}}</a> <span><a
                                href="{{url("/job_file/delete?tender_id=$tender_id&id=$job_file->id")}}"
                                target="_self" class="red-text"><i class="fa fa-times"></i></a></span><br>

                @endforeach
                <hr class="divider-icon">
                <h3>
                    UPLOAD JOB DOCUMENTS
                </h3>
                <br>
                <form action="{{url('/job_file/submit')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" name="job_file" class="form-control">
                    <input type="hidden" name="tender_id" value="{{$tender[0]->id}}" class="form-control">
                    <br>
                    <button class="btn btn-flat green white-text form-control" >
                        SEND JOB FILE TO {{json_decode($tender[0])->organisation->name}}
                    </button>

                </form>

            </div>
        @elseif($tender[0]->status == 'Job approved. Awaiting Invoice Submission')
            <center>
                <h2 class="cyan-text">
                    JOB DETAILS - <span class="light-green-text">{{$tender[0]->status}}</span>
                </h2>
            </center>
            <br>

            <div class="card card-body card-default">
                <div class="card-header">
                    <h2>ORGANISATION INFORMATION
                    </h2>
                </div>
                <br><br>
                Name : {{json_decode($tender[0])->organisation->name}}<br>
                Address : {{json_decode($tender[0])->organisation->address}}<br>
                Email : {{json_decode($tender[0])->organisation->email}}<br>
                Mobile : {{json_decode($tender[0])->organisation->mobile}}
            </div>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> APPROVED BOQ
                    </h2>
                </div>
                <br><br>

                <a href="{{asset(json_decode($tender[0])->bill_of_quantities->file)}}"
                   target="_self">{{json_decode($tender[0])->bill_of_quantities->file_name}}</a>
                <br>
                <div class="hidden">{{$tender_id = $tender[0]->id }}</div>
            </div>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> PURCHASE ORDERS
                    </h2>
                </div>
                <br>
                <h3>
                    UPLOADED PURCHASE ORDERS
                </h3>
                <br>
                @foreach($purchase_orders as $purchase_order)
                    <a href="{{asset($purchase_order->file)}}" target="_self">{{$purchase_order->name}}</a><br>
                @endforeach
            </div>
            <br>
            <br>
            @if(sizeof($job_files) !=0)
                <div class="card card-default card-body">
                    <div class="card-header">
                        <h2>JOB STATUS - {{ucfirst($tender[0]->status)}}</h2>
                    </div>
                    <br>
                    <hr class="divider-icon">
                    <h2>
                        Upload Invoice(s)<br>
                    </h2>
                    <br>
                    <form action="{{url('/invoice/submit')}}" method="post" enctype="multipart/form-data">
                        <label for="invoice">INVOICE(s)</label>
                        {{csrf_field()}}
                        <input type="hidden" name="tender_id" value="{{$tender[0]->id}}">
                        <input type="file" name="invoice" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-flat green white-text form-control">Send Invoice</button>
                    </form>

                </div>
            @endif


            <br>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> JOB DOCUMENTS
                    </h2>
                </div>
                <br>
                <h3>
                    UPLOADED JOB DOCUMENTS
                </h3>
                <br>
                @foreach($job_files as $job_file)
                    <a href="{{asset($job_file->file)}}" target="_self">{{$job_file->name}}</a><br>

                @endforeach

            </div>
        @endif
    </div>
    <br><br>
@endsection


