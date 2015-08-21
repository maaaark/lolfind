@extends('design')
@section('title', trans('forum::base.home_title'))
@section('css_addition')
	<link rel="stylesheet" type="text/css" href="/css/forum.css">
@stop
@section('header')
	<section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>@yield('forum_title')Forum</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            @yield('forum_pos')
        </div>
    </div><!-- Position -->
@stop

@section('content')
	<div class="container margin_30">
		@if(isset($content))
			{{ $content }}
		@else
			{{ trans('forum::base.no_content') }}
		@endif
	</div>
@stop