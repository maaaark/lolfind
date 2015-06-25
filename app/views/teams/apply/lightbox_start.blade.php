<h3 id="lightbox_apply_head_title">Apply {{ $ranked_team->name }}</h3>

@if(RankedTeam::loggedCanApplyToTeam($ranked_team->id))
   @if(RankedTeam::loggedCanApplyToTeam($ranked_team->id) == "already_applied")
      You already applied to this team.
   @else
      <div style="padding-bottom: 15px;" id="application_form_holder">
          Here you have the opportunity to send an application to the leader of {{ $ranked_team->name }}.<br/>
          Select your role(s) and leave a comment. If the team is interested in you, the team leader can contact you via our Chat-System.
          
          <div style="padding-top: 5px;">
             <h5>Your role</h5>
             <div id="application_role_sel"></div>
             <div style="padding-top: 5px;">
                 <h5>Your comment</h5>
                 <textarea name="description" id="application_comment" style="width: 100%;box-sizing: border-box;min-width: 100%;max-width: 100%;min-height: 120px;padding: 15px;font-size: 14px;resize: none;"></textarea>
             </div>
             
             <div style="padding-top: 35px;">
                 If the team leader of the other team contacts you, you will get the message in the notification bar at the top of the side.<br/>
                 With our chat system you can easily talk about the team, your plans on League of Legends and much more.
             </div>
             
             <div style="text-align: right;margin-top: 10px;">
                 <button id="application_submit_btn" class="btn_1" disabled>Submit application</button>
             </div>
          </div>
      </div>

      <script>
          region_arr_application = [];
          
          @if($ranked_team->looking_for_adc == 1)
              region_arr_application.push({title: "ADC", value: "adc", image: ["/img/roles/marksman.jpg", "rounded smaller"]});
          @endif
          @if($ranked_team->looking_for_support == 1)
              region_arr_application.push({title: "Support", value: "support", image: ["/img/roles/support.jpg", "rounded smaller"]});
          @endif
          @if($ranked_team->looking_for_mid == 1)
              region_arr_application.push({title: "Mid", value: "mid", image: ["/img/roles/mage.jpg", "rounded smaller"]});
          @endif
          @if($ranked_team->looking_for_top == 1)
              region_arr_application.push({title: "Top", value: "top", image: ["/img/roles/tank.jpg", "rounded smaller"]});
          @endif
          @if($ranked_team->looking_for_jungle == 1)
              region_arr_application.push({title: "Jungle", value: "jungle", image: ["/img/roles/fighter.jpg", "rounded smaller"]});
          @endif
          
          if(region_arr_application.length > 0){
              $("#application_role_sel").makeSelect("application_role", region_arr_application, function(select_box, input_value){
                  if(input_value.val().trim() != ""){
                      $("#application_submit_btn").prop("disabled", false);
                  } else {
                      $("#application_submit_btn").prop("disabled", true);
                  }
              });
          } else {
              html  = '<div style="color: rgba(0,0,0,0.6);text-align: center; padding: 35px;">';
              html += 'You can`t apply to this team, because they do not have any open roles at the moment.';
              html += '</div>';
              $("#application_form_holder").html(html);
          }
          
          $("#application_submit_btn").click(function(){
              allowLightboxCloseBG(false);
              lightboxCloseBtn(false);
              
              $.post("/teams/apply/post", {"team": {{ $ranked_team->id }}, "comment": $("#application_comment").val(), "role": $("#selection_application_role_sel_val").val() }).done(function(data){
                  allowLightboxCloseBG(true);
                  lightboxCloseBtn(true);

                  if(data.trim() == "error"){
                      html  = '<div style="margin-top: 35px;"">';
                      html += 'There was an error. We could not save your application. Please check back later.';
                      html += '</div>';
                      $("#application_form_holder").html(html);
                  } else {
                      html  = '<div style="font-size: 26px;text-align: center;line-height: 32px;">';
                      html += 'Your application was succesfully send to the leader of {{ $ranked_team->name }}';
                      html += '<div style="font-size: 16px;margin-top: 15px;">';
                      html += 'The leader can now refuse your application or get in contact with you.';
                      html += '</div>';
                      html += '</div>';
                      $("#application_form_holder").html(html);
                      $("#lightbox_apply_head_title").remove();
                  }
              });
              html = '<div style="padding: 35px;text-align: center;"><img src="/img/ajax-loader.gif" style="height: 45px;"><div>We submit your application. Please wait a few seconds.</div></div>';
              $("#application_form_holder").html(html);
          });
      </script>
   @endif
@else
   You cannot apply to this team ...
@endif