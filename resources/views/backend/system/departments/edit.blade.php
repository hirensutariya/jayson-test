@extends('layouts.master')

@section('page_title','Department Edit')

@section('breadcrumb')
		<h2>Department Edit</h2>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">

			<div class="ibox-content">
				<form action="{{ route('departments.update',$department->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data" id="departmentForm">
					@csrf
					@method('put')
					<div class="form-group">
						<label class="col-sm-2 control-label">Department Name</label>
						<div class="col-sm-8">
<input type="text" name="name" class="form-control" value="@if(old('name')){{old('name')}}@else{{$department->name}}@endif">
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
							<a href="{{ route('departments.index') }}" class="btn btn-white">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('custom_scripts')
    <script>
        $(document).ready(function () {
            $('#editDepartment').validate({
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: 'Please enter Department Name.'
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });

    </script>
@endsection
