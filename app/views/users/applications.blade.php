@extends('design')
@section('title', 'Your applications - ')
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>Your applications</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li>Applications</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">
            <div style="float: right;padding-top: 20px;">
                <a href="/teams" class="btn_1">Search for a team</a>
            </div>
            <h1>Pending applications</h1>

            @if(!isset($applications) || $applications == false || $applications->count() < 1)
                <div style="padding: 35px;">
                    You do not have any active applications at the moment.
                </div>
            @else
                <table class="table" style="margin-top: 25px;">
                    <thead>
                        <th>Team</th>
                        <th>Role</th>
                        <th>Your comment</th>
                        <th>Date</th>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td style="vertical-align: middle;">
                                    <span style="opacity: 0.5;">{{ strtoupper(Helpers::getRankedTeam($application->team)->region) }}:</span>
                                    <a href="/teams/{{ trim(Helpers::getRankedTeam($application->team)->region) }}/{{ trim(Helpers::getRankedTeam($application->team)->tag) }}">
                                        {{ Helpers::getRankedTeam($application->team)->name }}
                                    </a>
                                </td>
                                <td style="vertical-align: middle;">
                                    @if($application->role == "top")
                                        <img src="/img/roles/tank.jpg" style="height: 25px;border-radius: 50%;margin-right: 6px;"> Top
                                    @elseif($application->role == "mid")
                                        <img src="/img/roles/mage.jpg" style="height: 25px;border-radius: 50%;margin-right: 6px;"> Mid
                                    @elseif($application->role == "adc")
                                        <img src="/img/roles/marksman.jpg" style="height: 25px;border-radius: 50%;margin-right: 6px;"> ADC
                                    @elseif($application->role == "support")
                                        <img src="/img/roles/support.jpg" style="height: 25px;border-radius: 50%;margin-right: 6px;"> Support
                                    @else
                                        <img src="/img/roles/fighter.jpg" style="height: 25px;border-radius: 50%;margin-right: 6px;"> Jungle
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    @if(strlen(trim($application->comment)) > 85)
                                        {{ substr(strip_tags(trim($application->comment)), 0, 85) }} ...
                                    @else
                                        {{ trim(strip_tags($application->comment)) }}
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">{{ $application->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop