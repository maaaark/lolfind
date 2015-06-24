@extends('design')
@section('title', $user->summoner->name)
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
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
                    <h4>Contact</h4>
                    <button href="#" class="btn_1" onclick="fi_server_open_chat({{ $user->id }}, '{{ $user->summoner->name }}', '{{ $user->summoner->profileIconId }}')">Send meesage</button>
                </div>
            </div>
        </div>

    </div>
@stop