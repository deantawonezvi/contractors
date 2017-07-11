@extends('layouts.app')

@section('content')

    <div class="container">
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
                {{$tender->name}} - {{ucfirst($tender->status)}}
            </h4>
            <br>
            <h5>
                {{$tender->description}}
            </h5>
        </div>
            <hr>
        @endforeach
    </div>
    {{$tenders}}

@endsection