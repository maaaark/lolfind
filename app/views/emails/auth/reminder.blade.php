@extends('emails.mail')
@section('mail_content_headline')
    <strong style="font-size:20px; text-transform:uppercase;">Password reset</strong><br />
    You requested a reset for your password on Teamranked.com
@stop

@section('mail_content')
    Hello $summoner->name,<br/><br/>
    to reset your password, complete this form: {{ URL::to('password/reset', array($token)) }}.
@stop