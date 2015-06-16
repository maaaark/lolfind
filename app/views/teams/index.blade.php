@extends('design_left_sidebar')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
                <h1>Find a new team</h1>
                <p>Ridiculus sociosqu cursus neque cursus curae ante scelerisque vehicula.</p>
            </div>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Teamranked.com</a></li>
                <li><a href="#">Find a player</a></li>
                <li>Show players</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('sidebar')
	@include('layouts.filter_sidebar')
@stop
@section('content_page')

    <div class="content">

        <div id="tools">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="styled-select-filters">
                        <select name="sort_price" id="sort_price">
                            <option value="" selected>Sort by Role</option>
                            <option value="lower">ASC</option>
                            <option value="lower">DESC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="styled-select-filters">
                        <select  name="sort_rating" id="sort_rating">
                            <option value="" selected>Sort by ranking</option>
                            <option value="lower">ASC</option>
                            <option value="lower">DESC</option>
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <a href="#" class="bt_filters"><i class="icon-th"></i></a>
                    <a href="#" class="bt_filters"><i class=" icon-list"></i></a>
                    <a href="/teams/add" class="bt_filters"><i class=" icon-plus"></i> Add new team</a>
                </div>
            </div>
        </div><!--/tools -->


                    <div class="strip_all_tour_list player_searchbox wow fadeIn" data-wow-delay="0.1s">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2">
                                <div class="wishlist">
                                    <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">
                                        +<span class="tooltip-content-flip"><span class="tooltip-back">Add to favorites</span></span>
                                    </a>
                                </div>
                                <div class="center">
                                    <div style="text-align: center">
                                        <a href="#"><img src="img/leagues/gold_2.png" width="120" alt=""></a><br/>
                                        Gold 1<br/>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix visible-xs-block"></div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <div class="">
                                    <h3><strong>Summoner</strong></h3>
                                    <p>Lorem ipsum dolor sit amet, quem convenire interesset ut vix, ad dicat sanctus detracto vis. Eos modus dolorum... <a href="">more</a></p>
                                    <div class="row">
                                        <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                            <h5>Main Roles:</h5>
                                            <img src="http://teamranked.com/img/roles/marksman.jpg" class="img-circle" width="35" />
                                            <img src="http://teamranked.com/img/roles/support.jpg" class="img-circle" width="35" />
                                        </div>
                                        <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                            <h5>Championpool:</h5>
                                            <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/Jinx.png" class="img-circle" width="35" />
                                            <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/Sivir.png" class="img-circle" width="35" />
                                            <img src="http://ddragon.leagueoflegends.com/cdn/5.10.1/img/champion/Leona.png" class="img-circle" width="35" />
                                        </div>
                                        <div class="skill_profile col-lg-4 col-md-4 col-sm-4">
                                            <h5>Languages:</h5>
                                            <img src="http://teamranked.com/img/roles/marksman.jpg" class="img-circle" width="35" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="">
                                    <br/><br/>
                                    <p><a href="#" class="btn_1">Contact Player</a></p>
                                </div>
                            </div>
                        </div>
                    </div><!--End strip -->

        
        <div>
            <h2>{{ Lang::get("teams.search.team_suggestions") }}</h2>
            <div id="team_list_suggestions">
            	<div style="color: rgba(0,0,0,0.6);text-align: center;padding: 35px;">{{ Lang::get("teams.search.need_update_list") }}</div>
        	</div>
        </div>

        <hr>

        <div class="text-center">
            <ul class="pagination">
                <li><a href="#">Prev</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">Next</a></li>
            </ul>
        </div><!-- end pagination-->
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