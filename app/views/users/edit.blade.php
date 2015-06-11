@extends('layouts.small_header')
@section('title', "User bearbeiten")
@section('content')
    {{ Form::model($user, ['action' => ['UsersController@updateAccount'], 'method' => 'post']) }}
    @include('users.form')
    <br/>
    {{ Form::submit("Speichern", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
@stop