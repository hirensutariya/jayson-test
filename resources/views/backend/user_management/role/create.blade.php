@extends('layouts.master')

@section('page_title','Create Role')

@section('breadcrumb')
    <h2>Create Role </h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <form action="{{ route('role.store') }}" method="post" class="form-horizontal">
                        @csrf

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Role Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" value="@if(old('name')){{old('name')}}@endif">
                                @if($errors->has('name'))
                                    <span class="help-block m-b-none">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

{{--                        <div class="col-sm-6">--}}
{{--                            @foreach($pemissionList as $pemission)--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="form-check">--}}
{{--                                    <label class="form-check-label">--}}
{{--                                        <input class="form-check-input" type="checkbox" name="permissions[{{$pemission->id}}]">{{ $pemission->name }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ route('role.index') }}"class="btn btn-white">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

