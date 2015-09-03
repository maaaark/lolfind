@extends('emails.mail')
@section('mail_content_headline')
    <strong style="font-size:20px; text-transform:uppercase;">Test E-Mail</strong><br />
    Das ist eine Test-Email
@stop

@section('mail_content')
    Hallo,<br/>
    das ist eine Test-Email:<br/>
    $variable = {{ $variable }}<br/>
@stop