@extends('design', array('no_page_errors' => true))
@section('title', "Login - ")
@section('content')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        <div class="text-center"><img src="/img/teamranked_black.png" alt="" data-retina="true" width="280"></div>
                        @include('layouts.errors')
                        <hr>
                        {{ Form::open(array('url' => '/dologin')) }}
                            <div class="form-group">
                                <label>E-Mail</label>
                                {{ Form::text('email', Input::old('email'), array('placeholder' => 'example@lolquest.net', 'class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                {{ Form::password('password', array('class' => 'form-control')) }}
                            </div>
                            <p class="small">
                                <a href="/register">Register now</a> | <a href="/password/forgot">Reset password</a>
                            </p>
                            {{ Form::submit('Login', array('class' => 'btn_1')) }}
                            <a href="/register" class="btn_1 outline">Register</a>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).on("footer_resize", function(){
            $("#hero").css("height", $("#page_content_container").outerHeight());
        });
    </script>
@stop