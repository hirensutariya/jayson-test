@extends('layouts.master')

@section('page_title','Create State')

@section('breadcrumb')
    <h2>Create State </h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <form action="{{ route('states.store') }}" method="post" class="form-horizontal"
                          enctype="multipart/form-data" id="stateForm">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="country" id="country">
                                    @if(isset($countries) && $countries != "")
                                        @foreach($countries as $key=>$country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach;
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">State Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"
                                       value="@if(old('name')){{old('name')}}@endif">
                                @if($errors->has('name'))
                                    <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('states.index') }}"
                                   class="btn btn-white">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
