@extends('emails.mail')
@section('mail_content_headline')
    <strong style="font-size:20px; text-transform:uppercase;">New team calendar event</strong><br />
    Your team {{ $ranked_team->name }} has a new calendar event on Teamranked.com
@stop

@section('mail_content')
    Hello Summoner,<br/><br/>
    {{ $user->summoner->name }} created a new calendar event for <strong>{{ $ranked_team->name }}</strong>.<br/>
    Check out your account on <a style="color: #f25825;" href="http://teamranked.com">Teamranked.com</a><br/>
@stop