@extends('design_left_sidebar')
@section('title', "Neuer User - Schritt 1")
@section('content_site')
    {{ Form::open(array('action' => 'UsersController@step1_save')) }}


    <h2 class="headline">Fortschritt</h2>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;">
            Schritt 1 von 3
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
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop