@extends('layouts.app')

@section('content')

    <div class="container">
        @include('partials.info')
        @include('partials.error')
        <div class="banner shadow-1" style="margin-top: 50px;">
            <h2>
                <a class="cyan-text" href="/home"><i class="fa fa-home"></i> Home</a>
                <i class="fa fa-angle-right"></i>
                <span>{{$sub_contractor[0]->name}}</span>
            </h2>
        </div>
        <br>
        <hr class="divider-icon">
        <center>
            <h2 class="cyan-text">
                 TENDER BIDS
            </h2>
        </center>
        <br><br>
        @foreach($bids as $bid)
            <div class="card card-default card-body">
                <div class="card-title">
                    {{json_decode($bid)->tender->name}} - {{ucfirst($bid->status)}}
                </div>
                @if($bid->status == 'approved')
                    <button class="btn btn-flat green white-text"> VIEW JOB </button>
                @elseif($bid->status == 'declined')
                    <button class="btn btn-flat red white-text"> REMOVE BID </button>
                @endif
            </div>
            <hr>
        @endforeach
    </div>
{{$bids}}
@endsection