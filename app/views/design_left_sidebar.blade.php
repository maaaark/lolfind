@extends('design')
@section('content')
	<div class="content">
		<div class="col-md-3">
			@yield('sidebar')
		</div>
		<div class="col-md-9">
			@yield('content_page')
		</div>
	</div>
@stop