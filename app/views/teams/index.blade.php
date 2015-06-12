@extends('design_left_sidebar')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('sidebar')
    <h2>Search for teams</h2>
    {{ Lang::get("teams.region") }}
    <span id="region_sel"></span>

    {{ Lang::get("teams.league") }}
    <span id="leagues_sel"></span>

    {{ Lang::get("teams.primary_lang") }}
    <span id="prime_lang_sel"></span>

    {{ Lang::get("teams.scundary_lang") }}
    <span id="sec_lang_sel"></span>

    {{ Lang::get("teams.primary_role") }}
    <span id="prime_role_sel"></span>

    {{ Lang::get("teams.secundary_role") }}
    <span id="sec_role_sel"></span>
    
    <div style="margin-top: 5px;">
        <button class="small" style="float: right;">Update</button>
        <button class="small">Show suggestions</button>
    </div>
@stop
@section('content_page')
    <div class="content">
        <div style="float: right;"><button class="small" onclick="self.location.href = '/teams/add'">Add a team</div>
        <h1 class="heading">Teams</h1>
        
        <div style="margin-top: 60px;">
            [TEAM_LIST]<br/>
            Hier erscheint standardm&auml;&szlig;ig eine Liste an Vorschl&auml;gen (suggestions) f&uuml;r Teams (anhand von eingestellten Daten in den eigenen Teams)
        </div>
    </div>
    
    <script>
		$('#region_sel').makeSelect("region", [
		{
			title: 'EUW',
			value: 'euw',
			selected: true,
		},
		{
			title: 'NA',
			value: 'na',
		},
		]);
		
		$('#leagues_sel').makeSelect("league", [
		{
			title: 'Bronze',
			value: 'bronze',
			selected: true,
		},
		{
			title: 'Silver',
			value: 'silver',
		},
		{
			title: 'Gold',
			value: 'gold',
		},
		{
			title: 'Platinum',
			value: 'platinum',
		},
		{
			title: 'Master',
			value: 'master',
		},
		{
			title: 'Challenger',
			value: 'challenger',
		},
		]);
		
		languages_sel = [
		{
			title: "English",
			value: "english",
			selected: true,
		},
		{
			title: "German",
			value: "german",
		},
		]
		$('#prime_lang_sel').makeSelect("main_language", languages_sel);
		$('#sec_lang_sel').makeSelect("sec_language", languages_sel);
		
		summoner_roles = [
			{
				title: 'ADC',
				value: 'adc',
				selected: true,
			},
			{
				title: 'Support',
				value: 'support',
			},
			{
				title: 'Top',
				value: 'top',
			},
			{
				title: 'Mid',
				value: 'mid',
			},
			{
				title: 'Jungle',
				value: 'jungle',
			},
		];
		$('#prime_role_sel').makeSelect("primary_role", summoner_roles);
		$('#sec_role_sel').makeSelect("secundary_role", summoner_roles);
    </script>
@stop