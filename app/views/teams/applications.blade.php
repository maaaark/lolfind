@extends('design')
@section('title', $ranked_team->name)
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
                <li>Applications</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">
            <h2>Applications</h2>
            @if(isset($applications) AND $applications AND count($applications) > 0)
                <table class="table">
                @foreach($applications as $application)
                    <?php
                        $user_temp = Helpers::getUser($application->user);

                        $league_logo = "0_5";
                        $division = $user_temp->summoner->solo_division;
                        if($division == "I"){ $division = "1"; }
                        else if($division == "II"){ $division = "2"; }
                        else if($division == "III"){ $division = "3"; }
                        else if($division == "IV"){ $division = "4"; }
                        else { $division = "5"; }
                        $league_logo = strtolower(trim($user_temp->summoner->solo_tier))."_".trim($division);
                    ?>
                    
                    <tr>
                        <td style="font-size: 14px;">
                            @if(trim($user_temp->summoner->solo_tier) != "" AND trim($user_temp->summoner->solo_tier) != "none")
                                <img src="/img/leagues/{{ trim($league_logo) }}.png" style="height: 20px;margin-right: 6px;" class="tooltips" title="{{ trim(ucfirst(strtolower($user_temp->summoner->solo_tier))) }} {{ trim($division) }}">
                            @else
                                <img src="/img/leagues/0_5.png" style="height: 20px;margin-right: 6px;" class="tooltips" title="Unranked">
                            @endif
                            <img style="height: 25px;border-radius: 50%;margin-right: 6px;" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $user_temp->summoner->profileIconId }}.png">
                           {{ $user_temp->summoner->name }}
                        </td>
                        <td style="width: 200px;text-align: right;"><a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}/applications/{{ $application->id }}" class="btn_1">Details</a></td>
                    </tr>
                @endforeach
                </table>
            @else
                No active applications
            @endif
        </div>
    </div>
@stop