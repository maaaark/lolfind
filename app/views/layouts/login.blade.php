@extends('design')
@section('title', Lang::get("teams.site_title"))
@section('css_addition')
    <link rel="stylesheet" href="/css/teams.css">
@stop
@section('header')

@stop
@section('content')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        <p>
                            {{ $errors->first('email') }}
                            {{ $errors->first('password') }}
                        </p>
                        {{ Form::open(array('url' => '/dologin')) }}
                            <div class="form-group">
                                <label>E-Mail</label>
                                {{ Form::text('email', Input::old('email'), array('placeholder' => 'example@lolquest.net', 'class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                {{ Form::password('password', array('class' => 'form-control')) }}
                            </div>
                            <p class="small">
                                <a href="#">Forgot Password?</a>
                            </p>
                            {{ Form::submit('Einloggen', array('class' => 'btn_full')) }}
                            <a href="/register" class="btn_full_outline">Register</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop