<h3>Apply {{ $ranked_team->name }}</h3>

Here you have the opportunity to send an application to the leader of {{ $ranked_team->name }}.<br/>
Select your role(s) and leave a comment. If the team is interested in you, the team leader can contact you via our Chat-System.

<div style="padding-top: 5px; padding-bottom: 15px;" id="application_form_holder">
    <h5>Your role</h5>
    <div id="application_role_sel"></div>
    <div style="padding-top: 5px;">
        <h5>Your comment</h5>
        <textarea name="description" style="width: 100%;box-sizing: border-box;min-width: 100%;max-width: 100%;min-height: 120px;padding: 15px;font-size: 14px;resize: none;"></textarea>
    </div>
    
    <div style="padding-top: 35px;">
        If the team leader of the other team contacts you, you will get the message in the notification bar at the top of the side.<br/>
        With our chat system you can easily talk about the team, your plans on League of Legends and much more.
    </div>
    
    <div style="text-align: right;margin-top: 10px;">
        <button id="application_submit_btn" class="btn_1" disabled>Submit application</button>
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
</script>