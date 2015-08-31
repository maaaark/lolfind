@extends('design')
@section('title', "Start")
@section('css_addition')
    <link rel="stylesheet" type="text/css" href="/css/index.css">
    @stop
    @section('header')
            <!-- Slider -->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE  -->
                <li data-transition="fade" data-slotamount="7" data-masterspeed="500" data-saveperformance="on"
                    data-title="Intro Slide">
                    <!-- MAIN IMAGE -->
                    <img src="img/cover.jpg" alt="slidebg1" data-lazyload="img/cover.jpg" data-bgposition="center top"
                         data-bgfit="cover" data-bgrepeat="no-repeat">
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption white_heavy_40 customin customout text-center text-uppercase text-shadow"
                         data-x="center" data-y="center" data-hoffset="0" data-voffset="-20"
                         data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                         data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-speed="1000" data-start="1700" data-easing="Back.easeInOut" data-endspeed="300"
                         style="z-index: 5; max-width: auto; max-height: auto; white-space: nowrap;">League is more fun
                        with friends!
                    </div>
                    <!-- LAYER NR. 2 -->
                    <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0 text-center" data-x="center"
                         data-y="center" data-hoffset="0" data-voffset="15"
                         data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-speed="500" data-start="2600" data-easing="Power3.easeInOut" data-splitin="none"
                         data-splitout="none" data-elementdelay="0.05" data-endelementdelay="0.1"
                         style="z-index: 9; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div style="color:#ffffff; font-size:16px; text-transform:uppercase" class="text-shadow">
                            Find new players or teams matching your skills
                        </div>
                    </div>
                    <!-- LAYER NR. 3 -->
                    <div class="tp-caption customin tp-resizeme rs-parallaxlevel-0" data-x="center" data-y="center"
                         data-hoffset="0" data-voffset="70"
                         data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-speed="500" data-start="2900" data-easing="Power3.easeInOut" data-splitin="none"
                         data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-linktoslide="next"
                         style="z-index: 12;"><a href='/players' class="button_intro text-shadow">Find player</a> <a
                                href='/teams' class="text-shadow button_intro outline">Find teams</a>
                    </div>
                </li>
            </ul>
            <div class="tp-bannertimer tp-bottom"></div>
        </div>
    </div>
    <!-- End Slider -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">
            <div class="col-md-12" id="facebook_teamranked_add" style="display: none;">
                <div style="float: right;color: #fff;padding-top: 10px;padding-right: 10px;cursor: pointer;">
                    <i class="icon-cancel" id="facebook_teamranked_add_close"></i>
                </div>
                <a href="https://www.facebook.com/teamranked" color="#fff" target="_blank">
                    <div style="background-image: url(/img/facebook_icon_small.png);background-color: #3a5795;background-size: auto 33px;background-repeat: no-repeat;background-position: left 5px bottom;margin-bottom: 20px;color: #fff;">
                        <div style="padding: 10px;padding-left: 35px;padding-right: 20px;">
                            We are on facebook! Hit the like-button and never miss any news and features about teamranked.com
                        </div>
                    </div>
                </a>
            </div>
            <script>
                if(typeof $.cookie('fb_index_add') == "undefined" || $.cookie('fb_index_add') != "true"){
                    $("#facebook_teamranked_add").show();
                    $("#facebook_teamranked_add_close").click(function(){
                        $("#facebook_teamranked_add").hide(0);
                        $.cookie('fb_index_add', 'true');
                    });
                }
            </script>
            <div class="col-md-4 wow zoomIn" data-wow-delay="0.2s">
                <div class="feature_home">
                    <h3><span>120+</span> Teams looking for player</h3>

                    <p>
                        Many teams are looking for one or more players in specific roles or skills. Find a team that
                        fits your strength!
                    </p>
                    <a href="/teams" class="btn_1 outline">Search your team</a>
                </div>
            </div>

            <div class="col-md-4 wow zoomIn" data-wow-delay="0.4s">
                <div class="feature_home">
                    <h3><span>1000+</span> Players searching</h3>

                    <p>
                        You need one or more players for your League of Legends team to storm the ladder? Find players
                        with specific skills for your team!
                    </p>
                    <a href="/players" class="btn_1 outline">Find a new player</a>
                </div>
            </div>

            <div class="col-md-4 wow zoomIn" data-wow-delay="0.6s">
                <div class="feature_home">
                    <h3><span>Join</span> the community</h3>

                    <p>
                        Join the community and look for a player with specific roles/skills or search a team that fits
                        your skills! It's free!
                    </p>
                    <a href="/register" class="btn_1 outline">Register for free</a>
                </div>
            </div>

        </div>
        <!--End row -->
        @if(!Auth::check())
            <hr>

            <div class="row" style="background: url('img/network.png');">
                <div class="col-md-2 col-sm-2 hidden-xs">
                    <img src="img/fi_logo.png" height="250" alt="Laptop" class="">
                </div>
                <div class="col-md-10 col-sm-10">
                    <h3>Register your <span>free account</span> now</h3>

                    <p>
                        You are only three easy steps away from your new League of Legends team!
                    </p>
                    <ul class="list_order">
                        <li><span>1</span>Insert your summoner name</li>
                        <li><span>2</span>Verify your summoner</li>
                        <li><span>3</span>Search for teams and player</li>
                    </ul>
                    <a href="#" class="btn_1">Register now for free</a>
                    <br/><br/>
                </div>
            </div><!-- End row -->
        @endif
        <hr>

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="feature_home">
                    <h3>Recently updated <span>Players</span></h3>
                    <table class="last_tables">
                        @foreach($last_players as $player)
                            <tr>
                                <td>
                                    <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $player->profileIconId }}.png"
                                         class="img-circle" width="35">
                                    @if($player->solo_tier == "none")
                                        <img src="/img/leagues/0_5.png" class="tooltips" title="Unranked" width="35">

                                    @else
                                        <img src="/img/leagues/{{ trim(strtolower($player->solo_tier)) }}_1.png"
                                             class="tooltips" title="{{ trim(ucfirst(strtolower($player->solo_tier))) }}"
                                             width="35">
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::check())
                                        <a href="/summoner/{{ $player->region }}/{{ $player->name }}">{{ $player->name }}</a>
                                    @else
                                        Login to see Summoner Name
                                    @endif
                                </td>
                                <td>{{ $player->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br/>
                    <a href="/players" class="btn_1 outline">Find a player</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="feature_home">
                    <h3>Recently updated <span>Teams</span></h3>
                    <table class="last_tables">
                        @foreach($last_teams as $team)
                            <tr>
                                <td>
                                    @if(trim($team->ranked_league_5) == "" OR $team->ranked_league_5 == false OR $team->ranked_league_5 == "none" OR $team->ranked_league_5 == "false")
                                        <img src="/img/leagues/0_5.png" class="tooltips" title="Unranked" width="45">
                                    @else
                                        <img src="/img/leagues/{{ trim(strtolower(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, '_')))) }}_1.png"
                                             class="tooltips" title="{{ trim(ucfirst(strtolower(substr($team->ranked_league_5, 0, strpos($team->ranked_league_5, '_'))))) }}"
                                             width="45">
                                    @endif
                                </td>
                                <td>
                                    <a href="/teams/{{ $team->region }}/{{ $team->tag }}">{{ $team->name }}</a>
                                </td>
                                <td>{{ $team->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br/>
                    <a href="/teams" class="btn_1 outline">Find your team</a>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
@stop