@extends('layouts.master')

@section('page_title','Create User')

@section('breadcrumb')
		<h2>Create User</h2>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-content">
				<form action="{{ route('user.store') }}" method="post" class="form-horizontal">
					@csrf

					<div class="form-group">
						<label class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-8">
							<input type="text" name="firstname" class="form-control" value="@if(old('firstname')){{old('firstname')}}@endif">
							@if($errors->has('firstname'))
								<span class="help-block m-b-none">{{ $errors->first('firstname') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Last Name</label>
						<div class="col-sm-8">
							<input type="text" name="lastname" class="form-control" value="@if(old('lastname')){{old('lastname')}}@endif">
							@if($errors->has('lastname'))
								<span class="help-block m-b-none">{{ $errors->first('lastname') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">User Name</label>
						<div class="col-sm-8">
							<input type="text" name="username" class="form-control" value="@if(old('username')){{old('username')}}@endif">
							@if($errors->has('username'))
								<span class="help-block m-b-none">{{ $errors->first('username') }}</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">User Email</label>
						<div class="col-sm-8">
							<input type="text" name="email" class="form-control" value="@if(old('email')){{old('email')}}@endif">
							@if($errors->has('email'))
								<span class="help-block m-b-none">{{ $errors->first('email') }}</span>
							@endif
						</div>
					</div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">User Role</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="role" id="role">
                                @if(isset($roleList) && $roleList != "")
                                    @foreach($roleList as $key=>$role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach;
                                @endif
                            </select>
                            @if($errors->has('role'))
                                <span class="help-block m-b-none">{{ $errors->first('role') }}</span>
                            @endif
                        </div>
                    </div>

					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-1">
							<button class="btn btn-primary" type="submit">Save</button>
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
