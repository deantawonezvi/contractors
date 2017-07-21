@extends('layouts.app')

@section('content')

    <div class="container">
        @include('partials.info')
        @include('partials.error')
        <div class="banner shadow-1" style="margin-top: 50px;">
            <h2>
                <a class="cyan-text" href="/home"><i class="fa fa-home"></i> Home</a>
                <i class="fa fa-angle-right"></i>
                <span>{{$organisation[0]->name}}</span>
            </h2>
        </div>
        <br>
        <hr class="divider-icon">
        <center>
            <h2 class="cyan-text">
                PUBLISHED TENDERS
            </h2>
        </center>
        <br><br>
        @foreach($tenders as $tender)
        <div class="card card-default card-body">
            <h4 class="cyan-text">
                <a class="cyan-text" href="{{url("tender/details?id=$tender->id")}}">{{$tender->name}} - {{ucfirst($tender->status)}}</a>
            </h4>
            <br>
            <h5>
                {{$tender->description}}
            </h5>
            <br>
            <a href="{{url("/tender/delete?id=$tender->id")}}" class="btn btn-flat red white-text">Delete</a>
        </div>
            <hr>
        @endforeach
    </div>

@endsection