@extends('layouts.small_header')
@section('title', "User")
@section('content')

    <!--<table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>E-Mail</th>
            <th>Rolle</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td><a href="/users/{{ $user->id }}">{{ $user->id }}</a></td>
                <td><a href="/users/{{ $user->id }}">{{ $user->username }}</a></td>
                <td><a href="/users/{{ $user->id }}">{{ $user->email }}</a></td>
                <td><a href="/users/{{ $user->id }}">
                        @if($user->hasRole("admin"))
                            Administrator
                        @elseif($user->hasRole("moderator"))
                            Moderator
                        @else
                            User
                        @endif
                    </a></td>
            </tr>
        @endforeach
    </table>
    <a href="/admin/users/create" class="btn btn-primary">Neuen User anlegen</a>-->
    Work in progress

@stop