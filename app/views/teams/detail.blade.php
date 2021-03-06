@extends('design')
@section('title', $ranked_team->name." - ")
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <script>var refresh_after_finish_team_update = true;</script>
    <section class="medium-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="medium-parallax-content">
            @include("teams.team_header")
            <script>$("#team_navi_link_main").addClass("active");</script>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/teams">Teams</a></li>
                <li>{{ strtoupper($ranked_team->region) }} - {{ $ranked_team->name }}</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    @include("teams.ajax_updater")
    
	<div class="container margin_30">
		<div class="row">
			<div class="col-md-8">
                <div class="row strip_all_tour_list team_league_box">
                    <div class="col-md-6">
                        <h4>Ranked 5 vs. 5</h4>
                        @if($ranked_team->ranked_league_5 AND trim($ranked_team->ranked_league_5) != "" AND trim($ranked_team->ranked_league_5) != "none")
                            <?php
                                $league_logo = "0_5";
                                if(strpos($ranked_team->ranked_league_5, "_") > 0){
                                    $division = substr($ranked_team->ranked_league_5, strpos($ranked_team->ranked_league_5, "_") + 1);
                                    if($division == "I"){ $division = "1"; }
                                    else if($division == "II"){ $division = "2"; }
                                    else if($division == "III"){ $division = "3"; }
                                    else if($division == "IV"){ $division = "4"; }
                                    else { $division = "5"; }
                                    $league_logo = trim(substr($ranked_team->ranked_league_5, 0, strpos($ranked_team->ranked_league_5, "_")))."_".trim($division);
                                }
                            ?>
                            <img src="/img/leagues/{{ trim($league_logo) }}.png">
                            <div class="team_current_league_text">
                                {{ ucfirst(trim(substr($ranked_team->ranked_league_5, 0, strpos($ranked_team->ranked_league_5, "_")))) }} {{ $division }}

                                <div class="prediction">
                                    <div>Wins: <span class="wins">{{ $ranked_team->ranked_league_5_wins }}</span></div>
                                    <div>Losses: <span class="wins">{{ $ranked_team->ranked_league_5_losses }}</span></div>
                                    <div>League Points: <span class="wins">{{ $ranked_team->ranked_league_5_league_points }}</span></div>
                                </div>
                            </div>
                        @else
                            <img src="/img/leagues/0_5.png">
                            <div class="team_current_league_text">
                                Unranked

                                <div class="prediction">
                                    Placement prediction: <span>{{ ucfirst($ranked_team->league_prediction) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 team_league_box">
                        <h4>Ranked 3 vs. 3</h4>
                        @if($ranked_team->ranked_league_3 AND trim($ranked_team->ranked_league_3) != "" AND trim($ranked_team->ranked_league_3) != "none")
                            <?php
                                $league_logo = "0_5";
                                if(strpos($ranked_team->ranked_league_3, "_") > 0){
                                    $division = substr($ranked_team->ranked_league_3, strpos($ranked_team->ranked_league_3, "_") + 1);
                                    if($division == "I"){ $division = "1"; }
                                    else if($division == "II"){ $division = "2"; }
                                    else if($division == "III"){ $division = "3"; }
                                    else if($division == "IV"){ $division = "4"; }
                                    else { $division = "5"; }
                                    $league_logo = trim(substr($ranked_team->ranked_league_3, 0, strpos($ranked_team->ranked_league_3, "_")))."_".trim($division);
                                }
                            ?>
                            <img src="/img/leagues/{{ trim($league_logo) }}.png">
                            <div class="team_current_league_text">
                                {{ ucfirst(trim(substr($ranked_team->ranked_league_3, 0, strpos($ranked_team->ranked_league_3, "_")))) }} {{ $division }}

                                <div class="prediction">
                                    <div>Wins: <span class="wins">{{ $ranked_team->ranked_league_3_wins }}</span></div>
                                    <div>Losses: <span class="wins">{{ $ranked_team->ranked_league_3_losses }}</span></div>
                                    <div>League Points: <span class="wins">{{ $ranked_team->ranked_league_3_league_points }}</span></div>
                                </div>
                            </div>
                        @else
                            <img src="/img/leagues/0_5.png">
                            <div class="team_current_league_text">
                                Unranked

                                <div class="prediction">
                                    Placement prediction: <span>{{ ucfirst($ranked_team->league_prediction) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4" style="padding-top: 0px;">
                <div class="strip_all_tour_list" style="padding: 10px;">
                    <h4>Members</h4>

                    @if(Auth::check())
                        @foreach($ranked_team->player() as $player)
                        <div class="small_team_member">
                            <div style="float: right">
                                <span style="padding-right: 5px;">
                                   @if($player->summoner->solo_tier AND trim($player->summoner->solo_tier) != "" AND trim($player->summoner->solo_tier) != "none")
                                      <?php
                                         $pl_division = "1";
                                         if($player->summoner->solo_division == "II"){ $pl_division = "2"; }
                                         elseif($player->summoner->solo_division == "III"){ $pl_division = "3"; }
                                         elseif($player->summoner->solo_division == "IV"){ $pl_division = "4"; }
                                         elseif($player->summoner->solo_division == "V"){ $pl_division = "5"; }
                                      ?>
                                      <img src="/img/leagues/{{ trim(strtolower($player->summoner->solo_tier)) }}_{{ trim($pl_division) }}.png" style="height: 22px;" class="tooltips" title="{{ trim(ucfirst(strtolower($player->summoner->solo_tier))) }} {{ trim($pl_division) }}">
                                   @else
                                      <img src="/img/leagues/0_5.png" style="height: 22px;" class="tooltip" title="Unranked">
                                   @endif
                                </span>
                                <a href="/summoner/{{ trim($player->summoner->region) }}/{{ trim($player->summoner->name) }}" class="bt_filters">View profile</a>
                            </div>
                            <img class="team_member_icon" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $player->summoner->profileIconId }}.png">
                            
                            @if($player->summoner->summoner_id == $ranked_team->leader_summoner_id)
                                <span style="font-weight: bold;color: #555;">Leader:</span>
                            @endif
                            {{ $player->summoner->name }}
                        </div>
                        @endforeach
                    @else
                        <div style="padding: 20px;color: rgba(0,0,0,0.5);text-align: center;">
                            You need to <a href="/login">login</a> to see the members of this team.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 strip_all_tour_list">
                <div style="padding: 15px;">
                    <h4>Team-Description</h4>
                    @if($ranked_team->description AND trim($ranked_team->description) != "")
                        {{ strip_tags(nl2br(trim($ranked_team->description)), "<br/><br>") }}
                    @else
                        No description written yet.
                    @endif
                </div>
            </div>

            <div class="col-md-4" style="padding-top: 0px;">
                <div class="strip_all_tour_list" style="padding: 10px;">
                    <h4>Information</h4>
                    @if($ranked_team->looking_for_players == 1)
                        <div style="text-align: center;padding: 15px;color: rgb(0, 126, 0);">
                            Is looking for players.

                            @if(($check = RankedTeam::loggedCanApplyToTeam($ranked_team->id)))
                                @if($check == "can_apply")
                                   <div style="padding-top: 5px;"><a href="javascript:void(0);"class="btn_1 outline apply_team_btn">Apply</a></div>
                                @elseif($check == "already_applied")
                                   <div style="padding-top: 5px;"><a href="javascript:void(0);"class="btn_1 outline apply_team_btn" disabled>Already applied</a></div>
                                @endif
                            @endif
                        </div>
                            
                        <div style="padding: 5px;padding-bottom: 0px;text-align: left;">
                            <b>Team Language:</b> 
                            @if(trim($ranked_team->looking_for_lang) == "")
                                English
                            @else
                                {{ ucfirst(trim($ranked_team->looking_for_lang)) }}
                            @endif

                            <div style="padding-top: 15px;">
                                <div style="font-weight: bold;font-size: 14px;padding-bottom: 5px;">Open roles:</div>
                                @if($ranked_team->looking_for_adc == 1)
                                    <div class="ranked_team_role_open">
                                        <img src="/img/roles/marksman.jpg"> ADC
                                        @if(trim($ranked_team->looking_for_adc_desc) != "")
                                            <div class="desc">{{ trim($ranked_team->looking_for_adc_desc) }}</div>
                                        @endif
                                    </div>
                                @endif
                                @if($ranked_team->looking_for_support == 1)
                                    <div class="ranked_team_role_open">
                                        <img src="/img/roles/support.jpg"> Support
                                        @if(trim($ranked_team->looking_for_support_desc) != "")
                                            <div class="desc">{{ trim($ranked_team->looking_for_support_desc) }}</div>
                                        @endif
                                    </div>
                                @endif
                                @if($ranked_team->looking_for_jungle == 1)
                                    <div class="ranked_team_role_open">
                                        <img src="/img/roles/fighter.jpg"> Jungle
                                        @if(trim($ranked_team->looking_for_jungle_desc) != "")
                                            <div class="desc">{{ trim($ranked_team->looking_for_jungle_desc) }}</div>
                                        @endif
                                    </div>
                                @endif
                                @if($ranked_team->looking_for_top == 1)
                                    <div class="ranked_team_role_open">
                                        <img src="/img/roles/tank.jpg"> Top
                                        @if(trim($ranked_team->looking_for_top_desc) != "")
                                            <div class="desc">{{ trim($ranked_team->looking_for_top_desc) }}</div>
                                        @endif
                                    </div>
                                @endif
                                @if($ranked_team->looking_for_mid == 1)
                                    <div class="ranked_team_role_open">
                                        <img src="/img/roles/mage.jpg"> Mid
                                        @if(trim($ranked_team->looking_for_mid_desc) != "")
                                            <div class="desc">{{ trim($ranked_team->looking_for_mid_desc) }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div style="text-align: center;padding: 15px;">Not looking for players at the moment.</div>
                    @endif
                </div>
            </div>
		</div>
	</div>
@stop