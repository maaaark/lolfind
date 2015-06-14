@extends('design')
@section('title', $ranked_team->name)
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('content')
    <div class="content">
        <h1 class="heading">{{ $ranked_team->name }}</h1>
    </div>
@stop