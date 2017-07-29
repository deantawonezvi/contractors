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
        @if( $tender[0]->status == 'pending')
            <center>
                <h2 class="cyan-text">
                    CURRENT BIDS
                </h2>
            </center>
            <br><br>
            @foreach($bids as $bid)
                <div class="card card-default card-body card-hover">
                    <div class="card-title">
                        {{json_decode($bid)->sub_contractor->name}}
                    </div>
                    <br>
                    <div>
                        <h5>
                            Address - {{json_decode($bid)->sub_contractor->address}}<br>
                            Email Address - {{json_decode($bid)->sub_contractor->email}}<br>
                            Cellphone - {{json_decode($bid)->sub_contractor->mobile}}<br>
                            Telephone - {{json_decode($bid)->sub_contractor->telephone}}
                        </h5>
                    </div>
                    <hr>
                    <h2>
                        BOQ
                        <br><br>
                        <h5>
                            <a href="{{asset($bid->file)}}" target="_self">{{$bid->file_name}}</a>
                        </h5>
                    </h2>

                    <br>
                    <div>
                        <form action="{{url('/bid/approve')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="boq_id" value="{{$bid->id}}">
                            <input type="hidden" name="tender_id" value="{{$tender[0]->id}}">
                            <button type="submit" class="btn btn-flat green white-text">APPROVE</button>
                        </form>

                    </div>
                </div>
                <br>
            @endforeach
        @elseif($tender[0]->status == 'approved')
            <center>
                <h2 class="cyan-text">
                    JOB DETAILS
                </h2>
            </center>
            <br><br>
            <button class="btn btn-flat">VIEW JOB TIMELINE</button>
            <br><br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> SUB CONTRACTOR
                    </h2>
                </div>
                <br><br>
                Name : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->name}}<br>
                Address : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->address}}<br>
                Email : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->email}}<br>
                Mobile : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->mobile}}
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
                    <a href="{{asset($purchase_order->file)}}" target="_self">{{$purchase_order->name}}</a> <span><a
                                href="{{url("/purchase_order/delete?tender_id=$tender_id&id=$purchase_order->id")}}"
                                target="_self" class="red-text"><i class="fa fa-times"></i></a></span><br>
                @endforeach
                <hr class="divider-icon">
                <h3>
                    UPLOAD PURCHASE ORDER
                </h3>
                <br>
                <form action="{{url('/purchase_order/submit')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" name="purchase_order" class="form-control">
                    <input type="hidden" name="tender_id" value="{{$tender[0]->id}}" class="form-control">
                    <br>
                    <button class="btn btn-flat green white-text form-control">
                        SEND PURCHASE ORDER TO {{json_decode($tender[0])->bill_of_quantities->sub_contractor->name}}
                    </button>

                </form>

            </div>
            <br><br>

            @if( sizeof($job_files) != 0)
                <div class="card card-body card-default">
                    <div class="card-header">
                        <h2>
                            APPROVE SUBMITTED JOB
                        </h2>
                    </div>
                    <br>

                    <h3 class="blue-grey-text">
                        Uploaded Job Documents
                    </h3>
                    <br>
                    @foreach($job_files as $job_file)
                        <a href="{{asset($job_file->file)}}" target="_self">{{$job_file->name}}</a><br>
                    @endforeach
                    <br>
                    <hr class="divider-icon">
                    <form action="{{url('/job/approve')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="tender_id" value="{{$tender[0]->id}}" class="form-control">

                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                            <label for="comment">Comment</label>

                            <textarea name="comment" id="comment" class="form-control"></textarea>

                            @if ($errors->has('comment'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <button type="submit" name="approve" value="yes" class="btn btn-flat green white-text">
                                Approve Job
                            </button>
                            <button type="submit" name="approve" value="no" class="btn btn-flat red white-text">Decline
                                Job
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        @else
            <center>
                <h2 class="cyan-text">
                    JOB DETAILS - <span class="green-text light-green-text">{{$tender[0]->status}}</span>
                </h2>
            </center>
            <br><br>
            <button class="btn btn-flat">VIEW JOB TIMELINE</button>
            <br><br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> SUB CONTRACTOR
                    </h2>
                </div>
                <br><br>
                Name : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->name}}<br>
                Address : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->address}}<br>
                Email : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->email}}<br>
                Mobile : {{json_decode($tender[0])->bill_of_quantities->sub_contractor->mobile}}
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
            <br><br>

            @if( sizeof($job_files) != 0 && Auth::user()->role != 'finance')
                <div class="card card-body card-default">
                    <div class="card-header">
                        <h2>
                            APPROVE SUBMITTED JOB
                        </h2>
                    </div>
                    <br>

                    <h3 class="blue-grey-text">
                        Uploaded Job Documents
                    </h3>
                    <br>
                    @foreach($job_files as $job_file)
                        <a href="{{asset($job_file->file)}}" target="_self">{{$job_file->name}}</a><br>
                    @endforeach
                    <br>

                </div>
            @endif

            @if(Auth::user()->role == 'finance')
                <div class="card card-body card-default">
                    <div class="card-header">
                        <h2>
                            Confirm Payment
                        </h2>
                    </div>
                    <br>

                    <h3 class="blue-grey-text">
                        Uploaded Invoices from Sub Contractor
                    </h3>
                    <br>
                    @foreach($invoices as $invoice)
                        <a href="{{asset($invoice->file)}}" target="_self">{{$invoice->name}}</a><br>
                    @endforeach
                    <br>
                    <hr>
                    <h3>
                        Proof Of Payment
                    </h3>
                    <br>
                    @foreach($payments as $payment)
                        <a href="{{asset($payment->file)}}" target="_self">{{$payment->name}}</a> <span><a
                                    href="{{url("/payment/delete?tender_id=$tender_id&id=$payment->id")}}"
                                    target="_self" class="red-text"><i class="fa fa-times"></i></a></span><br>
                    @endforeach
                    <br>
                    <form action="{{url('/payment/submit')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="file" name="payment" class="form-control">
                        <input type="hidden" name="tender_id" value="{{$tender[0]->id}}" class="form-control">
                        <br>
                        <button class="btn btn-flat green white-text form-control">
                            SEND PROOF OF PAYMENT TO {{json_decode($tender[0])->bill_of_quantities->sub_contractor->name}}
                        </button>

                    </form>


                </div>

            @endif

        @endif
    </div>
    <br><br>
@endsection


