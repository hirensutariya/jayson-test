@extends('layouts.master')

@section('page_title','Create Country')

@section('breadcrumb')

    <h2>Create Country </h2>

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <form action="{{ route('countries.store') }}" method="post" class="form-horizontal"
                          enctype="multipart/form-data" id="countryForm">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"
                                       value="@if(old('name')){{old('name')}}@endif">
                                @if($errors->has('name'))
                                    <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country Code</label>
                            <div class="col-sm-8">
                                <input type="text" name="code" class="form-control"
                                       value="@if(old('code')){{old('code')}}@endif">
                                @if($errors->has('code'))
                                    <span class="help-block m-b-none">{{ $errors->first('code') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('countries.index') }}"
                                   class="btn btn-white">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
