@extends('design_left_sidebar')
@section('content_page')
    <div class="row profile">
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.fav_role') }}</h3>
            <img width="120" src="/img/roles/fighter.png" />
        </div>
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.fav_champion') }}</h3>
            <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/Jinx.png" class="img-circle" width="100" />
        </div>
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.solo_queue') }}</h3>
            <img width="120" src="http://summoner.flashignite.com/img/stats/tiers/{{ $user->summoner->solo_tier }}_I.png" alt="">
        </div>
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.languages') }}</h3>
            Deutsch<br/>
            Englisch
        </div>
    </div>
@stop
@section('sidebar')
    <div class="text-center">
        <h3>{{ $user->summoner->name }}</h3>
        <img height="120" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $user->summoner->profileIconId }}.png" class="img-circle" alt="{{ $user->summoner->name }}" /><br/>
        {{ $user->summoner->solo_tier }} {{ $user->summoner->solo_division }}
    </div>
@stop