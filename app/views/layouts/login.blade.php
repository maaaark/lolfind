@extends('design')
@section('title', Lang::get("teams.site_title"))
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
                        <div class="text-center"><img src="/img/teamranked_black.png" alt="" data-retina="true" width="280"></div>
                        <hr>
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
                            {{ Form::submit('Einloggen', array('class' => 'button_intro text-shadow')) }}
                            <a href="/register" class="btn_1 outline">Register</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop