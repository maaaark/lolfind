@extends('design')
@section('title', $ranked_team->name)
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('content')
	<div class="container margin_30">
	@include("teams.team_header")
	<script>$("#team_navi_link_settings").addClass("active");</script>

	<style>
	.looking_role_info_title{
		font-weight: bold;
		margin-top: 10px;
		margin-bottom: 3px;
	}

	.looking_role_info {
		width: 100%;
		box-sizing: border-box;
		height: 80px;
		resize: none;
	}
	</style>

	<div class="content">
		<h1>{{ Lang::get('teams.navi.settings') }}</h1>
		{{ Form::open(array('url' => '/teams/settings/post')) }}
		<table class="table">
			<tr>
				<td style="width: 30%;">{{ Lang::get('teams.settings.looking_for') }}</td>
				<td>
					@if($ranked_team->looking_for_players == 1)
						<label><input type="radio" name="looking_for" value="true" checked> Looking for players</label>
						<label><input type="radio" name="looking_for" value="false"> Not looking for players</label>
					@else
						<label><input type="radio" name="looking_for" value="true"> Looking for players</label>
						<label><input type="radio" name="looking_for" value="false" checked> Not looking for players</label>
					@endif
				</td>
			</tr>
			<tr>
				<td>{{ Lang::get('teams.settings.looking_in_league') }}</td>
				<td><div id="looking_in_league_sel"></div></td>
			</tr>
			<tr>
				<td>{{ Lang::get('teams.settings.looking_in_league_sec') }}</td>
				<td><div id="looking_in_league_sec_sel"></div></td>
			</tr>
		</table>

		<h3>{{ Lang::get("teams.settings.roles") }}</h3>
		<table class="table">
			<?php $roles_array = array("adc" => "ADC", "support" => "Support", "jungle" => "Jungler", "top" => "Top", "mid" => "Mid"); ?>
			@foreach($roles_array as $role => $role_name)
			<tr>
				<td style="width: 30%;">{{ Lang::get('teams.settings.looking_'.$role) }}</td>
				<td>
					@if($ranked_team["looking_for_".trim($role)] == 1)
						<label><input type="checkbox" name="looking_{{ $role }}" class="looking_role" value="true" checked> Looking for {{ $role_name }}</label>
						<div id="looking_{{ $role }}_box" style="display: block;">
					@else
						<label><input type="checkbox" name="looking_{{ $role }}" class="looking_role" value="true"> Looking for {{ $role_name }}</label>
						<div id="looking_{{ $role }}_box" style="display: none;">
					@endif

						<div class="looking_role_info_title">{{ Lang::get('teams.settings.looking_'.$role.'_info') }}</div>
						<textarea class="looking_role_info" name="looking_{{ $role }}_info">{{ trim($ranked_team["looking_for_".trim($role)."_desc"]) }}</textarea>
					</div>
				</td>
			</tr>
			@endforeach
		</table>

		<h3>{{ Lang::get("teams.settings.roles") }}</h3>
		<table class="table">
			<tr>
				<td style="width: 30%;">{{ Lang::get('teams.settings.looking_lang') }}</td>
				<td><div id="looking_language"></div></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value="{{ $ranked_team->id }}"></td>
				<td>{{ Form::submit(Lang::get("teams.settings.save"), array('class' => 'small')) }}</td>
			</tr>
		</table>
		{{ Form::close() }}
	</div>
	</div>

	<script>
	$(document).ready(function(){
		$('.looking_role').on('ifChecked', function(event){
			$("#"+$(this).attr("name")+"_box").show();
		});

		$('.looking_role').on('ifUnchecked', function(event){
			$("#"+$(this).attr("name")+"_box").hide();
		});

		console.log('{{ $ranked_team->looking_for_lang }}');
		$("#looking_in_league_sel").makeSelect("looking_in_league", dropdown_leagues_arr('{{ $ranked_team->looking_in_league }}'));
		$("#looking_in_league_sec_sel").makeSelect("looking_in_league_sec", dropdown_leagues_arr('{{ $ranked_team->looking_in_league_second }}'));
		$('#looking_language').makeSelect("looking_language", dropdown_languages_arr('{{ $ranked_team->looking_for_lang }}'));
		//$('#looking_language_sec').makeSelect("looking_language_sec", dropdown_languages_arr('{{ $ranked_team->looking_for_lang_second }}'));
	});
	</script>
@stop