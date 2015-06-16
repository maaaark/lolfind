@if(isset($ranked_teams) AND count($ranked_teams) > 0)
	@foreach($ranked_teams as $team)
		<div>{{ $team->name }}</div>
	@endforeach
@else
	No teams found :(
@endif