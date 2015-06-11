@extends('layouts.small_header')
@section('title', "User bearbeiten - ".$user->username)
@section('content')
    {{ Form::model($user, ['action' => ['UsersController@save_settings'], 'method' => 'post']) }}
    @include('users.form')
    <br/>
    {{ Form::submit("Speichern", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
@stop