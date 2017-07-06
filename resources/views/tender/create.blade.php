@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create Tender</div>

                    {{--
                                        <img src="{{url(\App\Organisation::find(6)->logo)}}">
                    --}}

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('tenders') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include('partials.info')
                            @include('partials.error')

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control" name="description"
                                           value="{{ old('description') }}" required autofocus>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('instructions') ? ' has-error' : '' }}">
                                <label for="instructions" class="col-md-4 control-label">Instructions</label>

                                <div class="col-md-6">
                                    <input id="instructions" type="text" class="form-control" name="instructions"
                                           value="{{ old('instructions') }}" required autofocus>

                                    @if ($errors->has('instructions'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('instructions') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('tender_type_id') ? ' has-error' : '' }}">
                                <label for="tender_type_id" class="col-md-4 control-label">Tender Type</label>

                                <div class="col-md-6">
                                    <select name="tender_type_id" id="tender_type_id">
                                        @foreach($tenderTypes as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('tender_type_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('tender_type_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('business_type_id') ? ' has-error' : '' }}">
                                <label for="business_type_id" class="col-md-4 control-label">Tender Category</label>

                                <div class="col-md-6">
                                    <select name="business_type_id" id="tender_type_id">
                                        @foreach($businessTypes as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('business_type_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('business_type_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
