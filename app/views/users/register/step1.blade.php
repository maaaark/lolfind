@extends('design')
@section('title', "New Account - Step 1")
@section('content')
    <section id="hero" class="register">
    <div class="container margin_30 register">
        <div class="">
    {{ Form::open(array('action' => 'UsersController@step1_save')) }}
    @include('layouts.errors')
    <h2 class="headline">Register Progress</h2>
    <div class="progress">
        <div class="progress-bar orange" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
            Step 1 of 4
        </div>
    </div>
    <br/>

    <h2 class="headline_no_border">Summoner information</h2>
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

    {{ Form::submit("Summoner prüfen", array('class' => 'btn_1')) }}
    {{ Form::close() }}
            </div>
    </div>
</div>
    </section>
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop