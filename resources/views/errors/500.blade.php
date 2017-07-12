@extends('layouts.error')

@section('title')
    Server Error
@stop

@section('content')
    <center>
        <img src="{{asset('img/linear-communication/svg/robot.svg')}}" alt="500" style="width:55%">
    </center>
    <div class="title red-text">
        Server error!
    </div>
    <h3 class="text-center red-text"><a class="red-text" href="/home"><i class="fa fa-home"></i> HOME</a></h3>

@stop
