@extends('design')
@section('title', "Neuer User - Step 3")
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
    {{ Form::open(array('action' => 'UsersController@step3_save')) }}


    <h2 class="headline">Progress</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
            Step 3 of 4
        </div>
    </div>
    <br/>

    @include('users.register.step3form')
    {{ Form::submit("Account anlegen", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
            </div>
        </div>
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop