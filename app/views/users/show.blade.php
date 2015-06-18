@extends('design_left_sidebar')
@section('content_page')
    <div class="row profile">
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.fav_role') }}</h3>
            <table style="width: 100%;">
                <tr>
                    <td><img width="100" src="/img/roles/marksman.jpg" class="img-circle"/></td>
                    <td>
                        <img width="45" src="/img/roles/fighter.jpg" class="img-circle"/><br/>
                        <img width="45" src="/img/roles/tank.jpg" class="img-circle"/>
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-md-3 text-center">
            <h3>{{ Lang::get('profile.fav_champion') }}</h3>
            <table style="width: 100%;">
                <tr>
                    <td><img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/Jinx.png" class="img-circle" width="100" /></td>
                    <td>
                        <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/Sivir.png" class="img-circle" width="45" /><br/>
                        <img src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/champion/Caitlyn.png" class="img-circle" width="45" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-3 text-center">
            <h3 style="margin-bottom: 5px;">{{ Lang::get('profile.solo_queue') }}</h3>
            <img width="120" src="http://summoner.flashignite.com/img/stats/tiers/{{ $user->summoner->solo_tier }}_I.png" alt="">
            
            @if($user_object AND $user_object->id AND $user_object->id > 0)
                <button onclick="fi_server_open_chat({{ $user_object->id }}, '{{ $user->summoner->name }}')">Chat &ouml;ffnen</button>
            @endif
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