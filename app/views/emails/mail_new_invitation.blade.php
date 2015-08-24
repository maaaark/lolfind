@extends('emails.mail')
@section('mail_content_headline')
    <strong style="font-size:20px; text-transform:uppercase;">New team invitation</strong><br />
    You have a new team invitation on Teamranked.com
@stop

@section('mail_content')
    Hello {{ $user->summoner->name }},<br/><br/>
    The team <strong>{{ $team->name }}</strong> invited you in their team.<br/>
    Check out your account on <a style="color: #f25825;" href="http://teamranked.com">Teamranked.com</a><br/>
@stop