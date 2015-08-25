@extends('design')
@section('title', "New Account - Step 3")
@section('content')
    <section id="hero" class="register">
        <div class="container margin_30 register">
        <div class="">
    {{ Form::open(array('action' => 'UsersController@step3_save')) }}


            @include('layouts.errors')
    <h2 class="headline">Register Progress</h2>

    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;">
            Step 3 of 4
        </div>
    </div>
    <br/>

    @include('users.register.step3form')
    {{ Form::submit("Next step", array('class' => 'btn_1')) }}
    {{ Form::close() }}
            </div>
        </div>
        </section>
        @include('users.register.register_resize_script')
@stop
@section('siebar')
    @include('layouts.sidebar')
@stop