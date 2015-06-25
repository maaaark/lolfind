@extends('design')
@section('title', Lang::get("teams.add.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
                <h1>{{ $ranked_team->name }}</h1>
                <p>You succesfully added your ranked team {{ $ranked_team->name }}</p>
            </div>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/teams">Teams</a></li>
                <li>Add a team</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <h1>Congratulations!</h1>
        You succesfully added your ranked-team to teamranked.com.

        <div>
            No you can easily search for players or customize your recruiting settings and your team-page.
        </div>

        <div style="padding-top: 35px;text-align: center;">
            <a href="/players" class="btn_1 outline">Search for players</a>
            <a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}" class="btn_1 outline">Customize recruitment settings</a>
            <a href="/teams/{{ $ranked_team->region }}/{{ $ranked_team->tag }}" class="btn_1 outline">Edit team page</a>
        </div>
    </div>
@stop