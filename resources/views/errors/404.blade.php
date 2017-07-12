@extends('layouts.error')

@section('title')
    Page not found
@stop

@section('content')
    <center>
        <img src="{{asset('img/linear-communication/svg/error-404.svg')}}" alt="404" style="width:55%">
    </center>
    <div class="title red-text">
        Whoops! Page not found.
    </div>
    <h3 class="text-center red-text"><a class="red-text" href="{{url('/home')}}"><i class="fa fa-home"></i> HOME</a></h3>
@stop
