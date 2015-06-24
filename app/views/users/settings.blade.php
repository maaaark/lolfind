@extends('design')
@section('title', "Edit User - ".$user->username)
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
    <div class="container margin_30">
        <div class="row">
    {{ Form::model($summoner, ['action' => ['UsersController@save_settings'], 'method' => 'post']) }}
    @include('users.register.step3form')
    <br/>
    {{ Form::submit("Save settings", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
    </div>
    </div>
@stop