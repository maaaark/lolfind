@extends('design')
@section('title', "Startseite")
@section('css_addition')
	<link rel="stylesheet" type="text/css" href="/css/index.css">
@stop
@section('content')
	<div class="index_opener">
		<div class="row" style="margin: auto;max-width: 1100px;">
			<div class="col-md-6">
				<div class="text_opener">
					<div class="big_text">Easily find new team members or new teams</div>
					<div class="medium_text">Log in with your Flashignite-Network Account and start looking for teammates or teams!</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form_box">
					<h2 style="margin-top: 0px;">Search for team or player</h2>
					<table class="index_form_table">
                        <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <span><label><input type="radio" name="player_or_team" value="player" checked> Player</label></span>
                                <span style="padding-left: 20px;"><label><input type="radio" name="player_or_team" value="team"> Team</label></span>
                            </td>
                        </tr>
						<tr>
							<td>Region:</td>
							<td><span id="region_sel"></span></td>
						</tr>
						<tr>
							<td>Liga</td>
							<td><span id="leagues_sel"></span></td>
						</tr>

						<tr>
							<td>Primary role</td>
							<td><span id="primary_role"></span></td>
						</tr>
						<tr>
							<td>Language:</td>
							<td><span id="main_language"></span></td>
						</tr>
						<tr>
							<td></td>
							<td><button>Show suggestions</button></td>
						</tr>
					</tbody></table>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-6">
				<h1>Startseite</h1>
				Inhalt der Startseite wird in den nächsten Tagen folgen.<br/>
				<br/>
				- Neueste Teams<br/>
				- Neueste Spieler<br/>

				@if(Auth::check())
				<button onclick="fi_server_open_chat(24, 'TorrnexT')">Chat mit TorrnexT</button>
				<button onclick="fi_server_open_chat(2, 'heyitsmark')">Chat mit heyitsmark</button>
				@endif
			</div>
		</div>
	</div>
	
	<script>
		$('#region_sel').makeSelect("region", dropdown_region_arr('euw'));
		$('#primary_role').makeSelect("primary_role", dropdown_roles_arr('adc'));

		$('#leagues_sel').makeSelect("league", dropdown_leagues_arr('silver'));
		$('#main_language').makeSelect("main_language", dropdown_languages_arr('english'));
	</script>
@stop