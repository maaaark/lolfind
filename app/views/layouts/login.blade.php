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

                        <form>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input type="text" class=" form-control " placeholder="E-Mail">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class=" form-control" placeholder="Password">
                            </div>
                            <p class="small">
                                <a href="#">Forgot Password?</a>
                            </p>
                            <a href="/login" class="btn_full">Sign in</a>
                            <a href="/register" class="btn_full_outline">Register</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop