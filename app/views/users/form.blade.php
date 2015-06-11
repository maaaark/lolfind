@if(!Auth::check())
<h2 class="headline_no_border">Account angaben</h2>
<table class="table table-striped">
    <tr>
        <td width="200"><strong>E-Mail</strong></td>
        <td>{{ Form::text('email', Input::old('email'),  array('class' => 'form-control')) }}</td>
    </tr>
    <tr>
        <td width="200"><strong>Password</strong></td>
        <td>{{ Form::password('password', array('class' => 'form-control')) }}</td>
    </tr>
    <tr>
        <td width="200"><strong>Password wiederholen</strong></td>
        <td>{{ Form::password('password_confirmation', array('class' => 'form-control')) }}</td>
    </tr>
</table>
<br/>
@endif
<h2 class="headline_no_border">Summoner Informationen</h2>
<table class="table table-striped">
    @if(Auth::check() && Auth::user()->summoner_veryfied == 1)
        <tr>
            <td width="200"><strong>Summoner Name</strong></td>
                <td>{{ Auth::user()->summoner->name }}</td>
        </tr>
        <tr>
            <td width="200"><strong>Server Region</strong></td>
            <td>{{ Auth::user()->summoner->region }}</td>
        </tr>
    @else
    <tr>
        <td width="200"><strong>Summoner Name</strong></td>
        @if(Auth::check() && Auth::user()->summoner)
            <td>{{ Form::text('summoner_name', Auth::user()->summoner->name,  array('class' => 'form-control')) }}</td>
        @else
            <td>{{ Form::text('summoner_name', Input::old('summoner_name'),  array('class' => 'form-control')) }}</td>
        @endif
    </tr>
    <tr>
        <td width="200"><strong>Server Region</strong></td>
        <td>
            <select name="region" class="form-control">
                <option value="euw">EU-West</option>
                <option value="na">Nordamerika</option>
            </select>
    </tr>
    @endif
    @if(Auth::user())
        @if(Auth::user()->summoner_veryfied == 1)
            <tr>
                <td><strong>Summoner</strong></td>
                <td>Verifiziert</td>
            </tr>
        @else
            <tr>
                <td><strong>Bestätigungs Code</strong></td>
                <td>
                    {{ Auth::user()->verify_string }}<br/>
                    <br/>
                    Benenne eine Runenseite in den oben stehenden Code um und speichere sie.<br/>
                    <br/>
                    Nach dem speichern, verifiziere deinen Summoner:<br/>
                    <a href="/verify_summoner" class="btn btn-primary">Summoner verifizieren</a>
                </td>
            </tr>
        @endif
    @endif
    <tr>
        <td width="200"><strong>Beschreibung</strong></td>
        <td>{{ Form::textarea('description', Input::old('description'),  array('class' => 'form-control')) }}</td>
    </tr>
</table>
