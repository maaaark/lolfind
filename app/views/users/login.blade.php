@extends('layouts.small_header')
@section('title', "User Login")
@section('content')
    <p>
        {{ $errors->first('email') }}
        {{ $errors->first('password') }}
    </p>

    <table width="100%">
        <tr>
            <td width="50%" valign="top">
                <h2 class="headline">User Login</h2>
                Logge dich mit deinem Flashignite Netzwerk Account ein.<br/>
                <br/>
                {{ Form::open(array('url' => '/login')) }}
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    {{ Form::text('email', Input::old('email'), array('placeholder' => 'example@lolquest.net', 'class' => 'form-control')) }}
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    {{ Form::password('password', array('class' => 'form-control')) }}
                </div>
                <br/>
                <p>{{ Form::submit('Einloggen', array('class' => 'btn btn-primary btn-block')) }}</p>
                {{ Form::close() }}
            </td>
            <td width="20"></td>
            <td valign="top">
                <h2 class="headline">Registrieren</h2>
                Du hast noch keinen Account?<br/>
                <br/>
                <strong>Dann zack zack:</strong><br/>
                <ul>
                    <li>Summoner eintragen</li>
                    <li>Verifizieren</li>
                    <li>FERTIG</li>
                </ul>
                <br/>
                <div class="center">
                    <a href="/register" class="btn btn-success">Neuen Account erstellen</a>
                </div>


            </td>
        </tr>
    </table>


@stop