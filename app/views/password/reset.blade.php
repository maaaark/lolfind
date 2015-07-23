@extends('design')
@section('title', Lang::get("teams.site_title"))
@section('content')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        @include('layouts.errors')
                        <p>
                            {{ $errors->first('email') }}
                            {{ $errors->first('password') }}
                        </p>
                        <div class="text-center"><img src="/img/teamranked_black.png" alt="" data-retina="true" width="280"></div>
                        <hr>
                        <form action="{{ action('RemindersController@postReset') }}" method="POST">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="email" name="email" class="form-control" placeholder="E-Mail"><br/>
                            <input type="password" name="password" class="form-control" placeholder="New password"><br/>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="New password again"><br/>
                            <br/>
                            <input type="submit" class="button_intro text-shadow" value="Reset Password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop