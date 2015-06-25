@extends('design')
@section('title', "You need to login")
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            <h1>You need to login</h1>
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/players">Player</a></li>
                <li>Player-Profile - You need to login</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div style="font-size: 28px;text-align: center;padding: 40px;line-height: 35px;">
            To see summoner-profiles you need to login with your account.
            <div style="font-size: 18px;margin-top: 25px;">
                You can login <a href="/login">here</a> or create a new account <a href="/register">here</a>.
            </div>
        </div>
    </div>
@stop