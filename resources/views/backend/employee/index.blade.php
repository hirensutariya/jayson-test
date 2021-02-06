@extends('layouts.master')

@section('page_title') Employee @endsection

@section('vue-css')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
@endsection

@section('content')
    <div id="app">
        <app></app>
    </div>
@endsection


@section('vue-script')
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
@endsection
