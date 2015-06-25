@extends('design_left_sidebar')
@section('title', "Neuer User - Schritt 4")
@section('content_page')
    {{ Form::open(array('action' => 'UsersController@step4_save')) }}


    <h2 class="headline">Fortschritt</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
            Schritt 4 von 4
        </div>
    </div>
    <br/>

    <h2 class="headline_no_border">Account angaben</h2>
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
            <td width="200"><strong>Password wiederholen</strong></td>
            <td>{{ Form::password('password_confirmation', array('class' => 'form-control')) }}</td>
        </tr>
    </table>
    <br/>
    <h2 class="headline">Verknüpfter Summoner</h2>
    <table>
        <tr>
            <td valign="top" width="100">
                <img width="80" height="80" src="http://ddragon.leagueoflegends.com/cdn/{{ $patchversion }}/img/profileicon/{{ $summoner->profileIconId }}.png" class="img-circle" alt="{{ $summoner->name }}" />
            </td>
            <td valign="top">
                <h3 style="margin:0; padding: 0;">{{ $summoner->name }}</h3>
                Level {{ $summoner->summonerLevel }} - {{ $summoner->region  }}<br/>
                Summoner ID: {{ $summoner->summoner_id }}
            </td>
        </tr>
    </table><br/>
    <br/>
    {{ Form::submit("Account anlegen", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop