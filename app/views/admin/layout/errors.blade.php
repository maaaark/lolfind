<style>
    div.alert {
        margin: 25px;
        margin-bottom: 0px;
    }
</style>

@if(Config::get('api.problems') == 1)
    <div class="alert alert-danger" role="alert">
        {{ trans("warnings.api_error") }}
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('message'))
    <div class="alert alert-info" role="alert">
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="alert alert-danger" role="alert">
        <strong>{{ Session::get('error') }}</strong>

        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif
    </div>
@else
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{ implode('', $errors->all(':message')) }}
        </div>
    @endif
@endif
@if(Session::has('status'))
    <div class="alert alert-warning" role="alert">
        {{ Session::get('status') }}
    </div>
@endif