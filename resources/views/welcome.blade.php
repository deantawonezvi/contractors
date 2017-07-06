<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('lib/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('lib/bs-enhance/bs-enhance.min.css')}}">

    <style>
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Register</a>
            @endif
        </div>
    @endif


</div>
<div class="container" style="margin-top: 150px">
    <form action="{{url('/tender/search')}}" method="post">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-6"><label for="channel_s">Category:</label>
                <select name="category" id="category" class="select2-select" ng-model="channel">
                    @foreach($businessTypes as $businessType)

                        <option value="{{$businessType->business_type_id}}">
                            {{json_decode($businessType)->business_type->name}}
                        </option>

                    @endforeach
                </select>
            </div>
            <div class="col-sm-6"><label for="channel_s">Tender Type:</label>
                <select name="tender_type" id="tender_type" class="select2-select" ng-model="channel_s">
                    @foreach($tenderTypes as $tenderType)
                        <option  value="{{$tenderType->tender_type_id}}">
                            {{json_decode($tenderType)->tender_type->name}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <button class="btn btn-md blue white-text pull-right">SEARCH</button>
    </form>

    <br><br>

    @foreach($tenders->sortBy('closing_at') as $tender)
        <div class="middle-content">
            <a href="{{url("tenders/$tender->id")}}"><h3>{{ucfirst($tender->name)}}</h3></a>
            <div>
                {{ucfirst($tender->description)}}<br><br>

                Closing Date - {{ Carbon\Carbon::parse($tender->closing_at)->toCookieString() }}
                <div class="pull-right">
                    <a href="/tender/search?tender_type={{json_decode($tender)->tender_type->id}}" class="blue-text">{{ucfirst(json_decode($tender)->tender_type->name)}}</a>
                </div>
            </div>


        </div>
        <br>
    @endforeach
    <center>{{$tenders->links()}}</center>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('lib/angular/angular.min.js') }}"></script>
<script src="{{ asset('js/index.min.js') }}"></script>
<script src="{{asset('lib/select2/dist/js/select2.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.select2-select').select2({
            allowClear: true,
            placeholder: 'Select An Option'
        });
    });
</script>
</body>
</html>
