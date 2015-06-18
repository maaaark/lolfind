@extends('design')
@section('title', $ranked_team->name)
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            @include("teams.team_header")
            <script>$("#team_navi_link_main").addClass("active");</script>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Teamranked.com</a></li>
                <li>Teams</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
	<div class="container margin_30">
		<div class="content">
			<h1>{{ Lang::get('teams.navi.main') }}</h1>
		</div>
	</div>
@stop