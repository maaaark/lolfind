@extends('design_left_sidebar')
@section('title', "Neuer User - Schritt 2")
@section('content_page')


    <h2 class="headline">Fortschritt</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
            Schritt 2 von 3
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
    <h2 class="headline">Bestätigungs Code</h2>
    <h3>{{Session::get('verify_code')}}</h3>
    Benenne eine Runenseite in den oben stehenden Code um und speichere sie.<br/>
    Nach dem speichern, verifiziere deinen Summoner mit einem klick auf den Button.<br/>
    <br/>
    <a href="/verify_summoner" class="btn btn-primary">Summoner verifizieren</a>
@stop
@section('sidebar')
    @include('layouts.sidebar')
@stop