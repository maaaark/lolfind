@extends('design')
@section('title', "Neuer User - Step 2")
@section('header')
    <section class="small-parallax-window" data-parallax="scroll" data-image-src="/img/player_background.jpg" data-natural-width="1400" data-natural-height="470">
        <div class="small-parallax-content">
            1
        </div>
    </section><!-- End section -->
    <div id="position">
        <div class="container">
            <ul>
                <li><a href="/">Teamranked.com</a></li>
                <li><a href="/register">Register</a></li>
                <li>Step 3</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">

    <h2 class="headline">Progress</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
            Step 2 of 4
        </div>
    </div>
    <br/>
    <table>
        <tr>
            <td valign="top" width="100">
                <img width="80" height="80" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" class="img-circle" alt="{{ $summoner->name }}" />
            </td>
            <td valign="top">
                <h3 style="margin:0; padding: 0;">{{ $summoner->name }}</h3>
                <div style="padding-top: 5px;">Level {{ $summoner->summonerLevel }} - {{ strtoupper($summoner->region) }}</div>
            </td>
        </tr>
    </table>
    <br/>
    <h2 class="headline">Validation Code</h2>
    <h3>{{Session::get('verify_code')}}</h3>
    Rename one of your Runepages to the code above and save it.<br/>
    After saving click on the button to verify your summoner.<br/>
    <br/>
    <a href="/verify_summoner" class="btn btn-primary">Verify summoner</a>
    </div>
    </div>
@stop