@extends('layouts.small_header')
@section('title', "Neuer User")
@section('content')
    {{ Form::open(array('action' => 'UsersController@save')) }}
    @include('users.form')
    {{ Form::submit("Speichern", array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
@stop