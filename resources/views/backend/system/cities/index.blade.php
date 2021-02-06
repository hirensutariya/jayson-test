@extends('layouts.master')

@section('page_title','City List')

@section('breadcrumb')
    City List
@endsection

@section('plugin_styles')
    <link rel="stylesheet" type="text/css" href="{{asset('backend/plugins/datatable/datatables.min.css')}}"/>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title"></h3>

            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <a href="{{ route('cities.create') }}" class="btn btn-primary btn-block"> Add New City</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <table id="city_datatable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <td>S.no</td>
                    <td>State Name</td>
                    <td>City Name</td>
                    <td>Created Date</td>
                    <td>Action</td>
                </tr>
                </thead>

            </table>
        </div>
    </div>
@endsection

@section('plugins_scripts')
    <script type="text/javascript" src="{{asset('backend/plugins/datatable/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/plugins/datatable/ajax-client-side.js')}}"></script>

@endsection
