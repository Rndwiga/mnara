@extends(config('mnara.views.layouts.master'))
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form role="form" method="POST" action="{{ route('mnara.login') }}">
                        {{ csrf_field() }}
                        <h1>Login Form</h1>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Username" required="" autofocus />
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required=""  />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary submit" type="submit" >Log in</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Lost your password?
                                <a href="{{route('mnara.password.request')}}" class="to_register"> Reset Password </a>
                            </p>
                            <p class="change_link">New to site?
                                <a href="{{route('mnara.register.form')}}" class="to_register"> Create Account </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> {{config('app.name')}}</h1>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
@endsection