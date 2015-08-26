@extends('emails.mail')
@section('mail_content_headline')
    <strong style="font-size:20px; text-transform:uppercase;">New player application</strong><br />
    You have a new player application on Teamranked.com
@stop

@section('mail_content')
    Hello Summoner,<br/><br/>
    Your team <strong>{{ $team->name }}</strong> has a new payer application.<br/>
    Check out your account on <a style="color: #f25825;" href="http://teamranked.com">Teamranked.com</a><br/>
@stop