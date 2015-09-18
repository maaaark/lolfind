@extends('design')
@section('title', $ranked_team->name." - Settings - ")
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
   <link rel="stylesheet" href="/css/teams_premium.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            @include("teams.team_header")
            <script>$("#team_navi_link_premium_config").addClass("active");</script>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="#">Teamranked.com</a></li>
                <li><a href="/teams">Teams</a></li>
                <li><a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}">{{ $ranked_team->name }}</a></li>
                <li>Customize permissions</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
	<div class="container margin_30">
        <div style="background: #fff;width: 100%;max-width: 800px;margin: auto;padding: 15px;">
            <h1>Customize permissions</h1>
            <form action="/teams/{{ trim($ranked_team->region) }}/{{ trim($ranked_team->tag) }}/settings/config-rights/action" method="post">
                <table class="teams_premium_permission_table">
                    <thead>
                        <th></th>
                        <th>Customize permissions</th>
                        <th style="display: none;">Manage forums</th>
                        <th>Edit calendar</th>
                    </thead>
                    <tbody>
                    @foreach($ranked_team->player() as $player)
                        @if(Helpers::get_userid_by_summoner($player->summoner_id, $player->summoner->region))
                            @if($player->summoner_id == $ranked_team->leader_summoner_id)
                                
                            @else
                                <tr>
                                    <td>
                                        <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $player->summoner->profileIconId }}.png" style="margin-right: 5px;height: 35px;border-radius: 50%;">
                                        {{ $player->summoner->name }}
                                        <input type="hidden" name="{{ $player->summoner->summoner_id }}_user_internal" value="{{ $player->summoner->id }}">
                                    </td>
                                    <td class="td_checkbox">
                                        @if(TeamPremiumCheck::can_change_config_rights(Helpers::get_userid_by_summoner($player->summoner->summoner_id, $ranked_team->region), $ranked_team))
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-permissions" checked>
                                        @else
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-permissions">
                                        @endif
                                    </td>
                                    <td class="td_checkbox" style="display: none;">
                                        @if(TeamPremiumCheck::can_manage_forums(Helpers::get_userid_by_summoner($player->summoner->summoner_id, $ranked_team->region), $ranked_team))
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-forums" checked>
                                        @else
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-forums">
                                        @endif
                                    </td>
                                    <td class="td_checkbox">
                                        @if(TeamPremiumCheck::can_edit_calendar(Helpers::get_userid_by_summoner($player->summoner->summoner_id, $ranked_team->region), $ranked_team))
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-calendar" checked>
                                        @else
                                            <input type="checkbox" name="user_{{ $player->summoner->id }}-calendar">
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div style="padding-top: 15px;text-align: right;">
                    <input type="submit" value="Save" class="btn_1">
                    <div style="float: left;text-align: left;color: #A2A2A2;">
                        You can just give summoners with an teamranked.com account permissions.
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop