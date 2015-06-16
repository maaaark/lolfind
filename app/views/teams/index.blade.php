@extends('design_left_sidebar')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('sidebar')
	<style>
		.filter_group {
			margin-bottom: 20px;
		}

		.filter_group .filter_name {
			font-weight: bold;
			margin-top: 3px;
		}
	</style>
    <h2>{{ Lang::get("teams.search.title") }}</h2>
    <div style="margin-bottom: 10px;">
    	{{ Lang::get("teams.search.select_sec") }}
	</div>

	<div class="filter_group">
	    <div class="filter_name">{{ Lang::get("teams.search.region") }}</div>
	    <span id="region_sel"></span>

	    <div class="filter_name">{{ Lang::get("teams.search.league") }}</div>
	    <span id="leagues_sel"></span>
    </div>

    <div class="filter_group">
	    <div class="filter_name">{{ Lang::get("teams.search.primary_lang") }}</div>
	    <span id="prime_lang_sel"></span>

	    <div class="filter_name">{{ Lang::get("teams.search.scundary_lang") }}</div>
	    <span id="sec_lang_sel"></span>
    </div>

    <div class="filter_group">
	    <div class="filter_name">{{ Lang::get("teams.search.primary_role") }}</div>
	    <span id="prime_role_sel"></span>

	    <div class="filter_name">{{ Lang::get("teams.search.secundary_role") }}</div>
	    <span id="sec_role_sel"></span>
    </div>
    
    <div>
        <button class="small" id="team_list_update_btn">{{ Lang::get("teams.search.update_btn") }}</button>
    </div>
@stop
@section('content_page')
    <div class="content">
        <div style="float: right;"><button class="small" onclick="self.location.href = '/teams/add'">Add a team</div>
        <h1 class="heading">Teams</h1>
        
        @if(isset($own_teams) AND count($own_teams) > 0)
        	<div style="margin-bottom: 60px;">
	            @foreach($own_teams as $team)
	                <div class="own_team_element_holder">
	                    <div class="own_team_element">
	                        <div class="tag">{{ $team->tag }}</div>
	                        <div class="name">{{ $team->name }}</div>
	                        <div class="button_div">
	                            <button class="small" onclick="self.location.href = '/teams/{{ trim($team->region) }}/{{ trim($team->tag) }}'">{{ Lang::get('teams.btn_show') }}</button>
	                        </div>
	                        <div style="clear: both;"></div>
	                    </div>
	                </div>
	            @endforeach
            </div>
            <div style="clear: both;"></div>
        @endif
        
        <div>
            <h2>{{ Lang::get("teams.search.team_suggestions") }}</h2>
            <div id="team_list_suggestions">
            	<div style="color: rgba(0,0,0,0.6);text-align: center;padding: 35px;">{{ Lang::get("teams.search.need_update_list") }}</div>
        	</div>
        </div>
    </div>
    
    <script>
		$('#region_sel').makeSelect("region", dropdown_region_arr('euw'));
		$('#leagues_sel').makeSelect("league", dropdown_leagues_arr('silver'));

		$('#prime_lang_sel').makeSelect("main_language", dropdown_languages_arr('english'));
		$('#sec_lang_sel').makeSelect("sec_language", dropdown_languages_arr('no_value', ["{{ Lang::get('teams.search.none') }}", "no_value"]));
		
		$('#prime_role_sel').makeSelect("primary_role", dropdown_roles_arr('adc'));
		$('#sec_role_sel').makeSelect("secundary_role", dropdown_roles_arr('no_value', ["{{ Lang::get('teams.search.none') }}", "no_value"]));

		// Update List
		can_update = true;
		function update_team_list_suggestions(){
			$("#team_list_update_btn").prop("disabled", false);

			$.post('/teams/team_list_suggestions', {
				region: $('#region_sel input').val(),
				league: $('#leagues_sel input').val(),
				main_lang: $('#prime_lang_sel input').val(),
				sec_lang: $('#sec_lang_sel input').val(),
				prime_role: $('#prime_role_sel input').val(),
				sec_role: $('#sec_role_sel input').val(),
			}).done(function(data){
				$("#team_list_update_btn").prop("disabled", false);
				can_update = true;
				//console.log(data);
				$("#team_list_suggestions").html(data);
			});
		}

		$("#team_list_update_btn").click(function(){
			if(can_update){
				can_update = false;
				update_team_list_suggestions();
			}
		});
    </script>
@stop