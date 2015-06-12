@extends('design')
@section('title', Lang::get("teams.add.site_title"))
@section('content')
   <div class="content">
      <h1>{{ Lang::get("teams.add.site_title") }}</h1>
      @if(Auth::check())
         
      @else
         <div style="padding: 25px;">
            {{ Lang::get("teams.add.login_needed") }}
         </div>
      @endif
   </div>
@stop