<?php
$need_api_request = true;
$date1   = date('Y-m-d H:i:s');
$date2   = $ranked_team->last_update_main_data;
$diff    = abs(strtotime($date2) - strtotime($date1));
$mins    = floor($diff / 60);

if($mins < 60){
    $need_api_request = false;
}
?>

@if($need_api_request)
	<script>
	function updateTheTeam(){
		$("#team_updater_progress").show();
		team_id = {{ $ranked_team->id }};
		$.get("/teams/update_team/"+team_id, {"ajax_load": "true"}).done(function(data){
			if(data.trim() == "success"){
				if(refresh_after_finish_team_update){
					location.reload();
				}
			}
		});
	}

	$(document).ready(function(){
		updateTheTeam();	
	});
	</script>
@endif