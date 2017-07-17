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
                    {{json_decode($bid)->tender->name}} - {{ucfirst($bid->status)}}<br>
                </div>
            Submitted BOQ - <a href="{{asset($bid->file)}}" target="_self">{{$bid->file_name}}</a>

            @if($bid->status == 'approved')
                    <form action="{{url('/tender/job/details')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{json_decode($bid)->tender->id}}">
                        <button type="submit" class="btn btn-flat green white-text"> VIEW JOB </button>
                    </form>
                @elseif($bid->status == 'declined')
                    <form action="{{url('/tender/job/delete')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$bid->id}}">
                        <button class="btn btn-flat red white-text"> REMOVE BID </button>

                    </form>
                @endif
            </div>
            <hr>
        @endforeach
    </div>
@endsection