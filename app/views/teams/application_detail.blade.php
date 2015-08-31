@extends('design')
@section('title', $ranked_team->name." - ")
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
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
                <li><a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}">{{ strtoupper($ranked_team->region) }} - {{ $ranked_team->name }}</a></li>
                <li><a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/applications">Applications</a></li>
                <li>Detail: {{ $user->summoner->name }}</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">
            <h2>{{ $user->summoner->name }}'s application</h2>
            <div class="col-md-8">
                <h4>Role</h4>
                @if($application->role == "top")
                    <img src="/img/roles/tank.jpg" style="float: left;margin-right: 25px;border-radius: 50%;">
                @elseif($application->role == "mid")
                    <img src="/img/roles/mage.jpg" style="float: left;margin-right: 25px;border-radius: 50%;">
                @elseif($application->role == "adc")
                    <img src="/img/roles/marksman.jpg" style="float: left;margin-right: 25px;border-radius: 50%;">
                @elseif($application->role == "support")
                    <img src="/img/roles/support.jpg" style="float: left;margin-right: 25px;border-radius: 50%;">
                @elseif($application->role == "jungle")
                    <img src="/img/roles/fighter.jpg" style="float: left;margin-right: 25px;border-radius: 50%;">
                @endif
                <div style="float: left;padding-top: 43px;font-size: 28px;">{{ strtoupper($application->role) }}</div>
                <div style="clear: both;"></div>

                <h4 style="margin-top: 35px;">Comment</h4>
                @if($application["comment"] AND trim($application["comment"]) != "")
                    {{ strip_tags(trim($application["comment"])) }}
                @else
                    {{ $user->summoner->name }} wrote no comment.
                @endif

                <div style="margin-top: 35px;">
                    <button class="btn_1" onclick="fi_server_open_chat({{ $user->id }}, '{{ $user->summoner->name }}', '{{ $user->summoner->profileIconId }}')" style="margin-right: 15px;">
                        Answer {{ $user->summoner->name }}
                    </button>
                    <a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/applications/{{ $application->id }}/delete">Delete application</a>
                </div>
            </div>
            <div class="col-md-4">
                <h4>{{ $user->summoner->name }} - Information</h4>
                <table class="table">
                    <tr>
                        <td>Summoner-Level</td>
                        <td>{{ $user->summoner->summonerLevel }}</td>
                    </tr>
                    <tr>
                        <td>Unranked wins</td>
                        <td>{{ $user->summoner->unranked_wins }}</td>
                    </tr>
                    <tr>
                        <td>Solo Queue</td>
                        <td>
                            @if(trim($user->summoner->solo_tier) != "" AND trim($user->summoner->solo_tier) != "none")
                                <?php
                                $league_logo = "0_5";
                                $division = $user->summoner->solo_division;
                                if($division == "I"){ $division = "1"; }
                                else if($division == "II"){ $division = "2"; }
                                else if($division == "III"){ $division = "3"; }
                                else if($division == "IV"){ $division = "4"; }
                                else { $division = "5"; }
                                $league_logo = strtolower(trim($user->summoner->solo_tier))."_".trim($division);
                                ?>
                                <img src="/img/leagues/{{ trim($league_logo) }}.png" style="height: 18px;">
                                {{ ucfirst(strtolower(trim($user->summoner->solo_tier))) }} {{ trim($division) }}
                            @else
                                <img src="/img/leagues/0_5.png" style="height: 18px;">
                                Unranked
                            @endif
                        </td>
                    </tr>
                </table>
                <div style="text-align: center;"><a href="/summoner/{{ $user->summoner->region }}/{{ $user->summoner->name }}" class="bt_filters">View profile</a></div>
            </div>
        </div>
    </div>
@stop