@extends('design')
@section('title', "Unknown Summoner")
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>Not registered summoner</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/players">Player</a></li>
                <li>Not registered summoner</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div style="font-size: 28px;text-align: center;padding: 40px;">
            The summoner you are looking for is not registered
            <div style="font-size: 18px;margin-top: 25px;">
                You know this summoner? Then tell him about Teamranked.com :)
            </div>
        </div>
    </div>
@stop