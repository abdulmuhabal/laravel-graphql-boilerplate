@extends('layouts.auth')

@section('content')
<!-- <div id="wrapper">
    <div class="card card-authentication1 mx-auto my-5">
        <div class="card-body">
            <div class="card-content p-2">
                <div class="text-center">
                    <img src="{{ asset('img/logo.png') }}" alt="logo icon" style="width: 250px">
                </div>
                <div class="card-title text-uppercase text-center py-3">Sign Up</div>

                <form method="POST" action="{{ route('register' ) }}" aria-label="{{ __('Register') }}">

                    @csrf

                    <div class="form-group">
                        <label>{{ __('lang.name') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="{{ __('lang.enter_name') }}">
                            <div class="form-control-position">
                                <i class="icon-user"></i>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                        <span class="text-danger">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span> @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.email_address') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="{{ __('lang.enter_email') }}" >
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                        <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span> @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.password') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="{{ __('lang.enter_password') }}">
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                        <span class="text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span> @endif
                    </div>

                    <div class="form-group">
                        <label class="">{{ __('lang.confirm_password') }}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('lang.enter_confirm_password') }}" >
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="icheck-material-primary">
                            <input type="checkbox" id="user-checkbox" checked="" />
                            <label for="user-checkbox">{{ __('lang.terms_condition') }}</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light">{{ __('lang.sign_up') }}</button>
                </form>
            </div>
        </div>
        <div class="card-footer text-center py-3">
            <p class="text-muted mb-0">{{ __('lang.already_have_account') }}<a href="{{ route('login'  ) }}"> {{ __('lang.sign_in_here') }}</a></p>
        </div>
    </div>
</div> -->
@endsection

