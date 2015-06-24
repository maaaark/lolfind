@extends('design')
@section('title', "Neuer User - Schritt 1")
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
                <li>Step 1</li>
            </ul>
        </div>
    </div><!-- Position -->
@stop
@section('content')
    <div class="container margin_30">
        <div class="row">
    {{ Form::open(array('action' => 'UsersController@step1_save')) }}


    <h2 class="headline">Progress</h2>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
            Step 1 of 4
        </div>
    </div>
    <br/>

    <h2 class="headline_no_border">Summoner Informationen</h2>
    <table class="table table-striped">
            <tr>
                <td width="200"><strong>Summoner Name *</strong></td>
                @if(Auth::check() && Auth::user()->summoner)
                    <td>{{ Form::text('summoner_name', Auth::user()->summoner->name,  array('class' => 'form-control')) }}</td>
                @else
                    <td>{{ Form::text('summoner_name', Input::old('summoner_name'),  array('class' => 'form-control')) }}</td>
                @endif
            </tr>
            <tr>
                <td width="200"><strong>Server Region *</strong></td>
                <td>
                    <select name="region" class="form-control">
                        <option value="euw">EU-West</option>
                        <option value="na">Nordamerika</option>
                    </select>
            </tr>
    </table>

    {{ Form::submit("Summoner prüfen", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
            </div>
    </div>
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop