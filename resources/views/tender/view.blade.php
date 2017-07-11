@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="middle-content">
            <center>
                <img src="{{asset($tender->organisation->logo)}}" class="circle" alt="tender_logo">
                <br><br>
                <h1>
                    {{$tender->name}}
                    <br>
                </h1>
                <br>
                <div class="blue-text">
                    <div>
                        <h2>
                            {{ucfirst(json_decode($tender)->tender_type->name)}}
                            <br><br>
                        </h2>
                    </div>
                    <h5>{{$tender->description}}</h5>
                </div>
            </center>
        </div>

        <br>
        <div class="middle-content">
            <h2>
                Instructions
            </h2>
            <br>
            <div class="blue-text">
                {{$tender->instructions}}
            </div>
        </div>
        <br>
        <div class="middle-content">
            <h2>
                Contact Details
            </h2>
            <br>
            <div>
                Email Address : <span class="blue-text">{{json_decode($tender)->organisation->email}}</span>
            </div>
            <div>
                Telephone Number : <span class="blue-text">{{json_decode($tender)->organisation->telephone}}</span>
            </div>
            <div>
                Cellphone Number : <span class="blue-text">{{json_decode($tender)->organisation->mobile}}</span>
            </div>
        </div>
        <hr>
        <div class="middle-content">
            <h2>
                Closing Date
            </h2>
            <br>
            <div class="blue-text">
                {{Carbon\Carbon::parse($tender->closing_at)->toCookieString() }}
            </div>
        </div>
        <br><br>
        <center>
            <a href="" class="col-sm-12 btn btn-flat blue white-text">BID</a>
        </center>
        <br><br>
        <br><br>

    </div>
@endsection
