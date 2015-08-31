@if(Config::get('api.problems') == 1)
    <div class="system_message red">
        {{ trans("warnings.api_error") }}
    </div>
@endif

@if(Session::has('success'))
    <div class="system_message green">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('message'))
    <div class="system_message">
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="system_message red">
        <strong>{{ Session::get('error') }}</strong>

        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif
    </div>
@else
    @if($errors->any())
        <div class="system_message red">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif
@endif
@if(Session::has('status'))
    <div class="system_message orange">
        {{ Session::get('status') }}
    </div>
@endif