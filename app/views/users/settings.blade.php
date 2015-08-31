@extends('design')
@section('title', "Edit User - ".Auth::user()->summoner->name." - ")
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
                <li><a href="/register">Settings</a></li>
                <li>{{ $user->username }}</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    {{ Form::model($summoner, ['action' => ['UsersController@save_settings'], 'method' => 'post']) }}
    <div class="account_settings_box">
        <h2>Account settings</h2>
        <table class="table account_settings_table">
            <tr>
                <td width="220" class="title">Prefered Roles</td>
                <td>
                    <label class="rolebox">{{ Form::checkbox('search_top', 1, Input::old('search_top')) }} Top-Lane</label>
                    <label class="rolebox">{{ Form::checkbox('search_jungle', 1, Input::old('search_jungle')) }} Jungle</label>
                    <label class="rolebox">{{ Form::checkbox('search_mid', 1, Input::old('search_mid')) }} Mid-Lane</label>
                    <label class="rolebox">{{ Form::checkbox('search_adc', 1, Input::old('search_adc')) }} Marksman</label>
                    <label class="rolebox">{{ Form::checkbox('search_support', 1, Input::old('search_support')) }} Support</label>
                </td>
            </tr>
            <tr>
                <td class="title">Favorite Champions</td>
                <td>
                    <select name="fav_champion_1">
                        @if($summoner->fav_champion_1 > 0)
                            <option value="{{ $summoner->fav_champion_1 }}">{{ $summoner->fav1->name }}</option>
                        @else
                            <option value="0">No favorite</option>
                        @endif
                        @foreach($champions as $champion)
                            <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                        @endforeach
                    </select>

                    <select name="fav_champion_2">
                        @if($summoner->fav_champion_2 > 0)
                            <option value="{{ $summoner->fav_champion_2 }}">{{ $summoner->fav2->name }}</option>
                        @else
                            <option value="0">No favorite</option>
                        @endif

                        @foreach($champions as $champion)
                            <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                        @endforeach
                    </select>

                    <select name="fav_champion_3">
                        @if($summoner->fav_champion_3 > 0)
                            <option value="{{ $summoner->fav_champion_3 }}">{{ $summoner->fav3->name }}</option>
                        @else
                            <option value="0">No favorite</option>
                        @endif
                        @foreach($champions as $champion)
                            <option value="{{ $champion->champion_id }}">{{ $champion->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="title">Your languages?</td>
                <td>
                    <select name="main_lang" id="m">
                        <option value="0">Main/Native language</option>
                        @foreach(Config::get("settings.langs") as $lang)
                            @if($summoner->main_lang == $lang[0])
                                <option value="{{ $lang[0] }}" selected>{{ $lang[1] }}</option>
                            @else
                                <option value="{{ $lang[0] }}">{{ $lang[1] }}</option>
                            @endif
                        @endforeach
                    </select>

                    <select name="sec_lang" id="s">
                        <option value="0">Secound language</option>
                        <option value="none">none</option>
                        @foreach(Config::get("settings.langs") as $lang)
                            @if($summoner->sec_lang == $lang[0])
                                <option value="{{ $lang[0] }}" selected>{{ $lang[1] }}</option>
                            @else
                                <option value="{{ $lang[0] }}">{{ $lang[1] }}</option>
                            @endif
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td class="title">Looking for team?</td>
                <td>
                    <label class="rolebox">{{ Form::checkbox('looking_for_team', 1, Input::old('looking_for_team')) }} I'm looking for a team</label>
                </td>
            </tr>
            <tr>
                <td class="title">Description</td>
                <td>{{ Form::textarea('description', Input::old('description'),  array('class' => 'form-control')) }}</td>
            </tr>
        </table>
    </div>
    
    <div class="account_settings_box">
        <h2>E-Mail settings</h2>

        You will get an email notification when some of the following events happen:
        <table class="table account_settings_table">
            <tr>
                <td width="220" class="title">Team invitation</td>
                <td>
                    <label class="rolebox">{{ Form::checkbox('email_player_invitation', 1, $user->check_email_settings('player_invitation')) }} When you get invited in a team</label>
                </td>
            </tr>
            <tr class="no_border">
                <td width="220" class="title">Player application</td>
                <td>
                    <label class="rolebox">{{ Form::checkbox('email_team_application', 1, $user->check_email_settings('team_application')) }} When a player applies for one of your teams</label>
                </td>
            </tr>
        </table>
    </div>

    <div style="width: 100%;max-width: 800px;margin: auto;text-align: right;padding-bottom: 20px;">
        {{ Form::submit("Save settings", array('class' => 'btn_1')) }}
    </div>
    {{ Form::close() }}
@stop