@if(Config::get('api.problems') == 1)
    <div class="bs-callout bs-callout-danger">
        {{ trans("warnings.api_error") }}
    </div>
@endif

@if(Session::has('success'))
    <div class="bs-callout bs-callout-success">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('message'))
    <div class="bs-callout bs-callout-warning">
        {{ Session::get('message') }}
    </div>
@endif
@if(Session::has('error'))
    <div class="bs-callout bs-callout-danger">
        <strong>{{ Session::get('error') }}</strong>

        @if($errors->has())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif
    </div>
@endif
@if(Session::has('status'))
    <div class="bs-callout bs-callout-success">
        {{ Session::get('status') }}
    </div>
@endif