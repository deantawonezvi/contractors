@extends('layouts.error')

@section('title')
    Pending
@stop

@section('content')
    <p class="pull-right">{{Auth::user()->name}}</p>
    <div class="title">
        Your account is pending.
    </div>
    <p>Please contact admin</p>
@stop
