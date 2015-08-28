@extends('design')
@section('title', 'Page not found')
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>Page not found</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li>Page not found</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
	<div class="container margin_30">
		<div style="padding-top: 30px;font-size: 42px;text-align: center;">
			404 - Error
		</div>
		<div style="padding-top: 25px;padding-bottom: 25px;font-size: 18px;text-align: center;">
			The page you are looking for was not found ...
		</div>
	</div>
@stop