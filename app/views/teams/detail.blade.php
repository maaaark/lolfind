@extends('design')
@section('title', $ranked_team->name)
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('content')
	<div class="container margin_30">
		@include("teams.team_header")
		<script>$("#team_navi_link_main").addClass("active");</script>

		<div class="content">
			<h1>{{ Lang::get('teams.navi.main') }}</h1>
		</div>
	</div>
@stop