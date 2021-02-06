@extends('layouts.master')

@section('page_title','Create User')

@section('breadcrumb')
    <h2>Create User</h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                @if(Session::has('message'))
                    <div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
                @endif

                <div class="ibox-content">
                    <form action="{{ route('backend.user.change.password.process') }}" method="post" class="form-horizontal">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Old Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="old_password" class="form-control" value="@if(old('old_password')){{old('old_password')}}@endif">
                                @if($errors->has('old_password'))
                                    <span class="help-block m-b-none">{{ $errors->first('old_password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" value="@if(old('password')){{old('password')}}@endif">
                                @if($errors->has('password'))
                                    <span class="help-block m-b-none">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation" class="form-control" value="@if(old('password_confirmation')){{old('password_confirmation')}}@endif">
                                @if($errors->has('password_confirmation'))
                                    <span class="help-block m-b-none">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('user.index') }}" class="btn btn-white">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
