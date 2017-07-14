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
                            {{$bid->description}}

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
                {{json_decode($tender[0])->bill_of_quantities->description}}<br>

            </div>
            <br>
            <div class="card card-body card-default">
                <div class="card-header">
                    <h2> PURCHASE ORDER
                    </h2>
                </div>
                <br>
                <h3>
                    UPLOAD PURCHASE ORDER
                </h3>
                <br>
                <form action="" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="file" name="purchase_order" class="form-control">
                    <input type="hidden" name="tender_id" value="{{$tender[0]->id}}" class="form-control">
                    <br>
                    <button class="btn btn-flat green white-text form-control" >
                        SEND PURCHASE ORDER TO {{json_decode($tender[0])->bill_of_quantities->sub_contractor->name}}
                    </button>

                </form>

            </div>
        @endif
    </div>
    {{$tender}}
@endsection


