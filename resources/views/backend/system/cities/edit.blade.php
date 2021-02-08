@extends('layouts.master')

@section('page_title','City Edit')

@section('breadcrumb')
    <h2>City Edit</h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <form action="{{ route('cities.update',$city->id) }}" method="post" class="form-horizontal"
                          enctype="multipart/form-data" id="cityForm">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="country" id="country">
                                    @if(isset($countries) && $countries != "")
                                        @foreach($countries as $key=>$country)
                                            @if($country->name == $getStateByCountry->country->name)
                                                <option value="{{$country->id}}" selected>{{$country->name}}</option>
                                            @else
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endif

                                        @endforeach;
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">State Name</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="state" id="state">
                                    @if(isset($states) && $states != "")
                                        @foreach($states as $key=>$state)
                                            @if($state->name == $city->state->name )
                                                <option value="{{$state->id}}" selected>{{$state->name}}</option>
                                            @else
                                                <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endif

                                        @endforeach;
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">City Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"
                                       value="@if(old('name')){{old('name')}}@else{{$city->name}}@endif">
                                @if($errors->has('name'))
                                    <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('cities.index') }}" class="btn btn-white">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
