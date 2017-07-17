@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="banner shadow-1" style="margin-top: 50px;">
            <h2>
                <a class="blue-text" href="/home"><i class="fa fa-home"></i> Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Tender</span>
                <i class="fa fa-angle-right"></i>
                <span class="blue-text">{{$tender[0]->name}} - {{json_decode($tender[0])->tender_type->name}} </span>
                <i class="fa fa-angle-right"></i>
                <span>Enter Bid</span>
            </h2>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-large card-default card-body">
                    @include('partials.info')
                    @include('partials.error')
                    <div class="center">
                        <img class="center" src="{{asset('img/linear-communication/svg/contract.svg')}}"
                             alt="contract" width="10%">
                    </div>
                    <br>
                    <h2 class="center">BID FOR TENDER</h2><br>
                    <h4 class="center blue-text">{{$tender[0]->name}}</h4><br>
                    <h4 class="center">ORGANISATION - <span
                                class="blue-text">{{json_decode($tender[0])->organisation->name}}</span></h4>
                    <br>
                    <h4 class="center">ORGANISATION ADDRESS - <span
                                class="blue-text">{{json_decode($tender[0])->organisation->address}}</span></h4>
                    <br>
                    <h4 class="center">ORGANISATION CONTACT NUMBER - <span
                                class="blue-text">{{json_decode($tender[0])->organisation->mobile}}</span></h4>
                    <br>
                    <h4 class="center">ORGANISATION EMAIL ADDRESS - <span
                                class="blue-text">{{json_decode($tender[0])->organisation->email}}</span></h4>
                    <br>
                    <h4 class="center">STATUS - <span class="blue-text">{{ucfirst($tender[0]->status)}}</span></h4>
                    <br>
                    <h4 class="center">CLOSING DATE - <span
                                class="blue-text">{{Carbon\Carbon::parse($tender[0]->closing_at)->toCookieString() }}</span>
                    </h4>
                </div>
                <br>
                <div class="card card-large card-default card-body">
                    <div class="card-title">
                        DESCRIPTION <br>
                        {{$tender[0]->description}}
                    </div>
                    <br>
                </div>
                <br>
                <div class="card card-large card-default card-body">
                    <div class="card-title">
                        INSTRUCTIONS <br>
                        {{$tender[0]->instructions}}
                    </div>
                    <br>
                </div>
                <br>
                <div class="card card-default card-large card-body">
                    <div class="red-text card-title">
                        ENTER BOQ AS BID
                    </div>

                    <form action="{{url('/bid/submit')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="tender_id" value="{{$tender[0]->id}}">
                        <input type="hidden" name="sub_contractor_id" value="{{Auth::user()->sub_contractor_id}}">
                        <input type="file" name="boq" class="form-control" required>
                        <br>

                        <button class="btn btn-flat blue white-text col-sm-12" type="submit">SUBMIT BID</button>

                    </form>

                </div>
                <br><br>


            </div>
        </div>
    </div>
@endsection
