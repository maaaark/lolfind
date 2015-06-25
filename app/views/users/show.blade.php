@extends('design')
@section('title', $user->summoner->name)
@section('css_addition')
    <link rel="stylesheet" href="/css/players.css">
@stop
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>{{ $user->summoner->name }}</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/players">Player</a></li>
                <li>{{ strtoupper($user->summoner->name) }}</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')

    <div class="container margin_30">
        <div class="row">
            <div class="col-md-8 strip_all_tour_list">
                <div style="padding: 15px;">
                    <div class="row">
                        <div class="col-md-3">
                            @if($user->summoner->solo_tier != "none")
                            <img src="/img/leagues/{{ trim(strtolower($user->summoner->solo_tier)) }}_1.png" class="tooltips" title="{{ trim(ucfirst(strtolower($user->summoner->solo_tier))) }}">
                            @else
                                <img src="/img/leagues/0_5.png" width="85" class="tooltips" title="Unranked">
                            @endif
                        </div>
                        <div class="col-md-5">
                            <h4>Roles</h4>

                                @if($user->summoner->search_top == 1)
                                    <div class="player_role img-circle"><img src="/img/roles/tank.jpg" class="img-circle" width="35" /></div>
                                @endif
                                @if($user->summoner->search_jungle == 1)
                                    <div class="player_role img-circle"><img src="/img/roles/fighter.jpg" class="img-circle" width="35" /></div>
                                @endif
                                @if($user->summoner->search_mid == 1)
                                     <div class="player_role img-circle"><img src="/img/roles/mage.jpg" class="img-circle" width="35" /></div>
                                @endif
                                @if($user->summoner->search_adc == 1)
                                     <div class="player_role img-circle"><img src="/img/roles/marksman.jpg" class="img-circle" width="35" /></div>
                                @endif
                                @if($user->summoner->search_support == 1)
                                     <div class="player_role img-circle"><img src="/img/roles/support.jpg" class="img-circle" width="35" /></div>
                                @endif
                        <div class="clearfix"></div>
                        </div>

                        <div class="col-md-4">
                            <h4>Favorite Champions</h4>
                            @if($user->summoner->fav_champion_1 != 0)
                                <div class="player_role img-circle"><img width="35" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $user->summoner->fav1->key }}.png" class="img-circle" width="100" /></div>
                            @else
                                <div class="player_role img-circle"></div>
                            @endif

                            @if($user->summoner->fav_champion_2 != 0)
                                <div class="player_role img-circle"><img width="35" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $user->summoner->fav2->key }}.png" class="img-circle" width="100" /></div>
                            @else
                                <div class="player_role img-circle"></div>
                            @endif

                            @if($user->summoner->fav_champion_3 != 0)
                                <div class="player_role img-circle"><img width="35" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/{{ $user->summoner->fav3->key }}.png" class="img-circle" width="100" /></div>
                            @else
                                <div class="player_role img-circle"></div>
                            @endif

                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <br/>
                    <h4>Description</h4>
                    {{ $user->summoner->description }}
                </div>
            </div>

            <div class="col-md-4" style="padding-top: 0px;">
                <div class="strip_all_tour_list" style="padding: 10px;">
                    @if(Auth::check() AND Auth::user()->id == $user->id)
                        <h4>Edit profile</h4>
                        You got new favorite champs? Or just want to change some information?
                        <div style="margin-top: 12px;text-align: center;">
                            <a href="/settings" class="btn_1">Customize your profile</a>
                        </div>
                    @else
                        <h4>Contact</h4>
                        Get in contact with <b>{{ $user->summoner->name }}</b>:
                        <div style="margin-top: 12px;text-align: center;">
                            <button href="#" class="btn_1" onclick="fi_server_open_chat({{ $user->id }}, '{{ $user->summoner->name }}', '{{ $user->summoner->profileIconId }}')">Send meesage</button>
                            <div class="btn_1 disabled tooltips" title="Coming soon!">Add as friend</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8 strip_all_tour_list">
                <h4 style="margin-top: 20px;margin-bottom: 15px;">Connected Ranked-Teams</h4>
                @if(isset($ranked_teams) AND is_array($ranked_teams) AND count($ranked_teams) > 0)
                    @foreach($ranked_teams as $team)
                        <div class="col-md-4 player_team_element">
                            <?php
                                $league_logo = "0_5";
                                if(strpos($team->ranked_league_5, "_") > 0){
                                    $division = substr($team->ranked_league_5, strpos($team->ranked_league_5, "_") + 1);
                                    if($division == "I"){ $division = "1"; }
                                    else if($division == "II"){ $division = "2"; }
                                    else if($division == "III"){ $division = "3"; }
                                    else if($division == "IV"){ $division = "4"; }
                                    else { $division = "5"; }
                                    $league_logo = trim(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, "_")))."_".trim($division);
                                }
                            ?>
                            <div class="team_icon"><img src="/img/leagues/{{ trim($league_logo) }}.png"></div>
                            <div class="team_name"><a href="/teams/{{ $team->region }}/{{ $team->tag }}">{{ $team->name }}</a></div>
                        </div>
                    @endforeach
                @else
                    <div style="padding: 35px;text-align: center;">{{ $user->summoner->name }} did not connect any Ranked-Teams with teamranked.com yet.</div>
                @endif
            </div>
        </div>

    </div>
@stop