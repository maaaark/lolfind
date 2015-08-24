@extends('design')
@section('title', "New Account - Step 4")
@section('content')
    <section id="hero" class="register">
        <div class="container margin_30 register">
    {{ Form::open(array('action' => 'UsersController@step4_save')) }}
            @include('layouts.errors')

    <h2 class="headline">Register Progress</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
            Step 4 of 4
        </div>
    </div>
    <br/>

    <h2 class="headline_no_border">Account details</h2>
    <table class="table table-striped">
        <tr>
            <td width="200"><strong>E-Mail</strong></td>
            <td>{{ Form::text('email', Input::old('email'),  array('class' => 'form-control')) }}</td>
        </tr>
        <tr>
            <td width="200"><strong>Password</strong></td>
            <td>{{ Form::password('password', array('class' => 'form-control')) }}</td>
        </tr>
        <tr>
            <td width="200"><strong>Password confirmation</strong></td>
            <td>{{ Form::password('password_confirmation', array('class' => 'form-control')) }}</td>
        </tr>
    </table>
    <br/>
    <h2 class="headline">Linked Summoner</h2>
    <table>
        <tr>
            <td valign="top" width="100">
                <img width="80" height="80" src="http://ddragon.leagueoflegends.com/cdn/{{ Config::get('settings.patch') }}/img/profileicon/{{ $summoner->profileIconId }}.png" class="img-circle" alt="{{ $summoner->name }}" />
            </td>
            <td valign="top">
                <h3 style="margin:0; padding: 0;">{{ $summoner->name }}</h3>
                Level {{ $summoner->summonerLevel }} - {{ $summoner->region  }}<br/>
                Summoner ID: {{ $summoner->summoner_id }}
            </td>
        </tr>
    </table><br/>
    <br/>
    {{ Form::submit("Create Account", array('class' => 'btn_1')) }}
    {{ Form::close() }}
            </div>
        </section>
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop