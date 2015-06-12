@extends('design')
@section('title', Lang::get("teams.add.site_title"))
@section('css_addition')
   <link rel="stylesheet" href="/css/teams.css">
@stop
@section('content')
   <div class="content">
      <h1>{{ Lang::get("teams.add.site_title") }}</h1>
      <div class="team_add_description">
         {{ Lang::get("teams.add.add_description") }}
      </div>
      
      @if(Auth::check())
         <div class="row">
            <div class="col-md-4">
               <div class="team_add_box">
                  <div class="team_add_title">Select a team</div>
                  <div class="team_add_content" id="team_list_holder">
                     <div style="padding: 20px;text-align: center;color: rgba(0,0,0,0.6);">
                        <img src="/img/ajax-loader.gif" style="height: 80px;">
                        <div style="padding-top: 10px;">
                           {{ Lang::get("teams.add.team_list_loading") }}
                        </div>
                     </div>
                  </div>
                  </div>
            </div>
            <div class="col-md-8">
               <div class="team_add_box">
                  <div class="team_add_title">Add your team</div>
                  <div class="team_add_content" id="team_list_continue">
                     <div style="color: rgba(0,0,0,0.4);">
                        {{ Lang::get("teams.add.wait_for_team_sel") }}
                     </div>
                  </div>
                  <div class="team_add_continue_flat">
                     <button class="small" disabled>{{ Lang::get("main.continue") }}</button>
                  </div>
               </div>
            </div>
         </div>
      @else
         <div style="padding: 25px;">
            {{ Lang::get("teams.add.login_needed") }}
         </div>
      @endif
   </div>
@stop