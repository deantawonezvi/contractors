@extends('layouts.error')

@section('title')
    Inactive Account
@stop

@section('content')
    <p class="pull-right">{{Auth::user()->name}}</p>
    <div class="title">
        Your account has been temporarily deactivated.
    </div>
    <p>Please contact admin</p>
@stop
