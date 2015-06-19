@extends('design')
@section('title', $user->summoner->name)
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <script>$("#team_navi_link_main").addClass("active");</script>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/teams">Player</a></li>
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
                        <div class="col-md-4">
                            <h4>Main Roles</h4>
                            <table>
                                <tr>
                                    <td valign="top">
                                        @foreach($user->playerroles as $role)
                                            @if($role->looking_for_top == 1)
                                                <img src="/img/roles/tank.jpg" class="img-circle" width="35" />
                                            @endif
                                            @if($role->looking_for_jungle == 1)
                                                <img src="/img/roles/fighter.jpg" class="img-circle" width="35" />
                                            @endif
                                            @if($role->looking_for_mid == 1)
                                                <img src="/img/roles/mage.jpg" class="img-circle" width="35" />
                                            @endif
                                            @if($role->looking_for_adc == 1)
                                                <img src="/img/roles/marksman.jpg" class="img-circle" width="35" />
                                            @endif
                                            @if($role->looking_for_support == 1)
                                                <img src="/img/roles/support.jpg" class="img-circle" width="35" />
                                            @endif
                                        @endforeach
                                    </td>
                                    <td valign="top">

                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h4>Favorite Champions</h4>
                        </div>
                        <div class="col-md-4">
                            <h4>Main Roles</h4>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4" style="padding-top: 0px;">
                <div class="strip_all_tour_list" style="padding: 10px;">
                    <h4>Solo Queue</h4>
                    <img src="/img/leagues/{{ trim(strtolower($user->summoner->solo_tier)) }}_1.png" class="tooltips" title="{{ trim(ucfirst(strtolower($user->summoner->solo_tier))) }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 strip_all_tour_list">
                <div style="padding: 15px;">
                    <h4>Team-Description</h4>

                </div>
            </div>

            <div class="col-md-4" style="padding-top: 0px;">
                <div class="strip_all_tour_list" style="padding: 10px;">
                    <h4>Information</h4>

                </div>
            </div>
        </div>
    </div>
@stop