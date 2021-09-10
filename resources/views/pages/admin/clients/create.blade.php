@extends('layouts.admin')

@section('content')
<?php \App::getLocale() === "ar" ? $name_index = "name_ar" : $name_index = "name_en" ?>
<form action="{{ route('admins.clients.store') }}" method="POST" enctype="multipart/form-data" >
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
        <input name="role" type="hidden" value="CLIENT"/>
<div class="row">
    <div class="col-md-8">
    </div>
    <div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="form-header text-uppercase">{{ __('lang.client') }} <i class="fa fa-user-circle"></i></h5>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <label for="input-16">{{ __('lang.name') }}</label>
                            <input type="text" class="form-control form-control input-shadow @error('name') is-invalid @enderror" id="input-1" placeholder="" name="name" value="{{old('name', '')}}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label for="input-17">{{ __('lang.email') }}</label>
                            <input type="text" class="form-control form-control input-shadow @error('email') is-invalid @enderror" id="input-2" placeholder="" name="email" value="{{old('email', '')}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label for="input-18">{{ __('lang.phone') }}</label>
                            <input type="text" class="form-control form-control input-shadow @error('phone') is-invalid @enderror" id="input-3" placeholder="" name="phone" value="{{old('phone', '')}}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label for="input-18">{{ __('lang.password') }}</label>
                            <input type="password" class="form-control form-control input-shadow @error('password') is-invalid @enderror" id="input-4" placeholder="" name="password" value="{{old('password', '')}}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label for="input-18">{{ __('lang.password_confirmation') }}</label>
                            <input type="password" class="form-control form-control input-shadow @error('password') is-invalid @enderror" id="input-4" placeholder="" name="password_confirmation" value="{{old('password_confirmation', '')}}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>  
                    </div>
                </div>
     
            </div>
            <div class="row no-print">
                <div class="col-lg-12">
                    <div class="float-sm-right">
                    <button type="submit" class="btn btn-primary">{{ __('lang.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

</form>
@endsection

