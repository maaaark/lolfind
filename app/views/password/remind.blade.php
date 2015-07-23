@extends('design')
@section('title', Lang::get("teams.site_title"))
@section('content')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        <div class="text-center"><img src="/img/teamranked_black.png" alt="" data-retina="true" width="280"></div>
                        <hr>
                        @include('layouts.errors')
                        <form action="{{ action('RemindersController@postRemind') }}" method="POST">
                            <input type="email" name="email" placeholder="Your E-Mail adress" class="form-control">
                            <br/>
                            <div class="center">
                                <input type="submit" value="Send password" class="button_intro text-shadow">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop