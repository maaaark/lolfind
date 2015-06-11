@extends('design')
@section('content')
	<div class="col-md-3 sidebar">
		@yield('sidebar')
	</div>
	<div class="col-md-9 main_content">
		@yield('content_page')
	</div>
@stop