@extends('design')
@section('content')
    <div class="container margin_30">
	<div class="content">
        <div class="row">
            <div class="col-md-3 sidebar">
                @yield('sidebar')
            </div>
            <div class="col-md-9 main_content">
                @yield('content_page')
            </div>
        </div>
    </div>
    </div>
@stop
