@extends(config('mnara.views.layouts.master'))
@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form role="form" method="POST" action="{{ route('mnara.register') }}">
                        {{ csrf_field() }}
                        <h1>Create Account</h1>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Your name" required="" />
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Email" required="" />
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="" />
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password" placeholder="Confirm password" class="form-control" name="password_confirmation" required />
                        </div>


                        <div>
                            <button class="btn btn-block btn-primary submit" type="submit">Register</button>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="{{route('mnara.login.form')}}" class="to_register"> Log in </a>
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