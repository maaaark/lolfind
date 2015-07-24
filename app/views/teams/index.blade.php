@extends('design_left_sidebar')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
                <h1>Find a new team</h1>
                <p class="text-shadow">Find your perfect team matching your style and skill. Never play alone again!</p>
            </div>
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
@section('sidebar')
	@include('teams.filter_sidebar')
@stop
@section('content_page')
    <div class="content">
        @if(isset($own_teams) AND count($own_teams) > 0 AND is_array($own_teams))
            <h2>Your teams</h2>
            <div class="row own_teams" style="margin-bottom: 25px;">
                 @foreach($own_teams as $team)
                    <div class="col-md-4">
                        <div class="own_team_el" style="box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.1);background: #fff;">
                            <div style="font-size: 18px;padding: 10px;border-bottom: 1px solid rgba(0,0,0,0.075);">{{ $team->name }}</div>
                            <div style="padding: 10px;">
                                <div style="margin-top: 6px;text-align: right;">
                                    <div style="float: left;color: rgba(0,0,0,0.5);padding-top: 5px;">{{ strtoupper($team->tag) }}</div>
                                    <a href="/teams/{{ $team->region }}/{{ $team->tag }}" class="btn_1">Ansehen</a>
                                </div>
                            </div>
                        </div>
                    </div>
                 @endforeach
            </div>
        @endif
        
        <div id="tools">
            <div class="row">
                <div class="text-right" style="margin-right: 15px;">
                    <a href="/applications" class="bt_filters button_intro">Your applications</a>
                    <a href="/teams/add" class="bt_filters button_intro"><i class="icon-plus"></i> Add new team</a>
                </div>
            </div>
        </div><!--/tools -->
        
        <div>
            <!-- <h2>{{ Lang::get("teams.search.team_suggestions") }}</h2> -->
            <div id="team_list_suggestions">
               @if(isset($team_list))
                    @include("teams.suggestion_list", array("ranked_teams" => $team_list))
               @else
                    <div style="color: rgba(0,0,0,0.6);text-align: center;padding: 35px;">{{ Lang::get("teams.search.need_update_list") }}</div>
               @endif
            </div>
        </div>

        <hr>


        <div class="text-center">
            {{ $team_list->links() }}
        </div><!-- end pagination-->
    </div>
    
    <script>
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
                unranked_search: $('#search_unranked').prop('checked')
			}).done(function(data){
				$("#team_list_update_btn").prop("disabled", false);
				can_update = true;
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
