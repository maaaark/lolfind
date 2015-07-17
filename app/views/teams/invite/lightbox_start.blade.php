<h3 id="lightbox_apply_head_title">Invite {{ $user->summoner->name }}</h3>

@if($user->summoner->looking_for_team == 1)
    @if(RankedTeam::loggedCanInvitePlayer($user->summoner))
      <div style="padding-bottom: 15px;" id="application_form_holder">
          Here you have the opportunity to send an invtiatino to {{ $user->summoner->name }}.<br/>
          Select your role(s) and leave a comment. If the summoner is interested in your team, he can answer your invitation in the flashignite-chat system.
          
          <div style="padding-top: 5px;">
             <style>
                .invite_label_role_icon {
                    height: 25px;
                    margin-left: 5px;
                    margin-right: 5px;
                    border-radius: 50%;
                }
                
                .role_labels_holder label {
                    margin-right: 30px;
                }
             </style>
             
             <h5 id="select_your_team_header">Select your team</h5>
             <div id="team_sel_invite"></div>
             
             <h5>Roles of {{ $user->summoner->name }} your team is interested in:</h5>
             <?php $open_roles = false; ?>
             <div class="role_labels_holder">
                 @if($user->summoner->search_top)
                    <?php $open_roles = true; ?>
                    <label><input type="checkbox" value="true" name="role_top"> <img src="/img/roles/tank.jpg" class="invite_label_role_icon">Top</label>
                 @endif
                 
                 @if($user->summoner->search_mid)
                    <?php $open_roles = true; ?>
                    <label><input type="checkbox" value="true" name="role_mid"> <img src="/img/roles/mage.jpg" class="invite_label_role_icon">Mid</label>
                 @endif
                 
                 @if($user->summoner->search_jungle)
                    <?php $open_roles = true; ?>
                    <label><input type="checkbox" value="true" name="role_jungle"> <img src="/img/roles/fighter.jpg" class="invite_label_role_icon">Jungle</label>
                 @endif
                 
                 @if($user->summoner->search_adc)
                    <?php $open_roles = true; ?>
                    <label><input type="checkbox" value="true" name="role_adc"> <img src="/img/roles/marksman.jpg" class="invite_label_role_icon">ADC</label>
                 @endif
                 
                 @if($user->summoner->search_support)
                    <?php $open_roles = true; ?>
                    <label><input type="checkbox" value="true" name="role_support"> <img src="/img/roles/support.jpg" class="invite_label_role_icon">Support</label>
                 @endif
                 
                 @if($open_roles == false)
                    {{ $user->summoner->name }} is not looking for any role at the moment.
                 @endif
             </div>
             
             <div id="invitation_role_sel"></div>
             <div style="padding-top: 5px;">
                 <h5>Your comment</h5>
                 <textarea name="description" id="invitation_comment" style="width: 100%;box-sizing: border-box;min-width: 100%;max-width: 100%;min-height: 120px;padding: 15px;font-size: 14px;resize: none;"></textarea>
             </div>
             
             <div style="text-align: right;margin-top: 10px;">
                 <button id="invitation_submit_btn" class="btn_1" disabled>Submit invitation</button>
             </div>
          </div>
      </div>
      
      <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_flat-orange',
            radioClass: 'iradio_flat-orange'
        });
        
        $(document).ready(function(){
            @if(isset($teams) && $teams->count() > 0)
                $("#team_sel_invite").makeSelect("team_select", [
                    <?php $need_first_select = true; ?>
                    @foreach($teams as $team)
                        @if($need_first_select)
                            { title: "{{ $team->name }}", value: "{{ $team->id }}", selected: true },
                        @else    
                            { title: "{{ $team->name }}", value: "{{ $team->id }}" },
                        @endif
                    @endforeach    
                ]);
            @else
                $("#select_your_team_header").remove();
                $("#invitation_submit_btn").replaceWith("<button class='btn_1' disabled>You have no teams, to invite this player.</button>");
            @endif
            
            var labels_role_count = 0;
            $('.role_labels_holder input').on('ifChecked', function(event){
                labels_role_count++;
                
                if(labels_role_count > 0){
                    $("#invitation_submit_btn").prop("disabled", false);
                } else {
                    $("#invitation_submit_btn").prop("disabled", true);
                }
            });
            $('.role_labels_holder input').on('ifUnchecked', function(event){
                labels_role_count--;
                
                if(labels_role_count > 0){
                    $("#invitation_submit_btn").prop("disabled", false);
                } else {
                    $("#invitation_submit_btn").prop("disabled", true);
                }
            });
            
            $("#invitation_submit_btn").click(function(){
                allowLightboxCloseBG(false);
                lightboxCloseBtn(false);
                
                roles = [];
                if(typeof $("input[name='role_top']") != "undefined" && $("input[name='role_top']").is(":checked")){
                    roles.push("top");
                }
                if(typeof $("input[name='role_mid']") != "undefined" && $("input[name='role_mid']").is(":checked")){
                    roles.push("mid");
                }
                if(typeof $("input[name='role_adc']") != "undefined" && $("input[name='role_adc']").is(":checked")){
                    roles.push("adc");
                }
                if(typeof $("input[name='role_support']") != "undefined" && $("input[name='role_support']").is(":checked")){
                    roles.push("support");
                }
                if(typeof $("input[name='role_jungle']") != "undefined" && $("input[name='role_jungle']").is(":checked")){
                    roles.push("jungle");
                }
                
                $.post("/teams/invite/post", {"user": {{ $user->id }}, "comment": $("#invitation_comment").val(), "roles": JSON.stringify(roles), "team": $("#selection_team_sel_invite_val").val() }).done(function(data){
                    allowLightboxCloseBG(true);
                    lightboxCloseBtn(true);
                    
                    console.log(data);
                    
                    if(data.trim() == "error"){
                        html  = '<div style="margin-top: 35px;"">';
                        html += 'There was an error. We could not save your invitatino. Please check back later.';
                        html += '</div>';
                        $("#application_form_holder").html(html);
                    } else {
                        html  = '<div style="font-size: 26px;text-align: center;line-height: 32px;">';
                        html += 'Your invitatino was succesfully send to {{ $user->summoner->name }}';
                        html += '<div style="font-size: 16px;margin-top: 15px;">';
                        html += '{{ $user->summoner->name }} can now refuse your invitation or get in contact with you.';
                        html += '</div>';
                        html += '</div>';
                        $("#application_form_holder").html(html);
                        $("#lightbox_apply_head_title").remove();
                    }
                });
                    
                html = '<div style="padding: 35px;text-align: center;"><img src="/img/ajax-loader.gif" style="height: 45px;"><div>We submit your invitation. Please wait a few seconds.</div></div>';
                $("#application_form_holder").html(html);
            });
        });
      </script>
   @else
      This summoner is not looking for a team at the moment.
   @endif
@else
   You cannot invite any players...
@endif