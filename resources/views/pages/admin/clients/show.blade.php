@extends('layouts.admin')

@section('css')
<style type="text/css">
.bordered-box-theme{
    border: 4px solid #FBB03B;
    border-radius: 15px;
    padding: 1rem;
    min-height: 128px;
}

</style>

@endsection 

@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
        <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
            <!-- <li class="nav-item">
                <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="fa fa-user-o"></i> <span class="hidden-xs">{{ __('lang.profile') }}</span></a>
            </li> -->
            <li class="nav-item">
                <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link active"><i class="icon-note"></i> <span class="hidden-xs">{{ __('lang.edit') }}</span></a>
            </li>
        </ul>
        <div class="tab-content p-3">
            <!--/row-->
            <div class="tab-pane active" id="edit">
                <form  action="{{ route('admins.clients.update', $data['client']->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                {{ method_field('PUT') }}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.name') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="name" value="{{ $data['client']->name}}">
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.phone') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ $data['client']->phone}}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.email') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ $data['client']->email}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.update_subscription') }} </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.expiry_date') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control" type="date" name="expiry_date" value="{{ $data['client']->expiry_date}}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.change_password') }} </label>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.password') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">{{ __('lang.password_confirmation') }} </label>
                        <div class="col-lg-9">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" value="">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    
                    
   
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9">

                            <input type="submit" class="btn btn-primary" value="{{ __('lang.save') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="col-lg-4">
        <div class="card profile-card-2">

            <div class="card-body pt-4">
                <div class="col-md-12  pb-4">
                    <h3 class="">{{ __('lang.client')}} {{ $data['client']->id."#"}}</h3>
                    <h4 class="bold">{{ $data['client']->name}}</h4>
                    <h5 class="card-title"> <b>{{ __('lang.phone') }}:</b> {{ $data['client']->phone}}</h5>
                    <h5 class="card-title"> <b>{{ __('lang.email') }}:</b> {{ $data['client']->email}}</h5>
                    <h5 class="card-title"> <b>{{ __('lang.expiry_date') }}:</b> {{ $data['client']->expiry_date}}</h5>
                </div>
                <div class="col-md-12">
                    <div class="row"> 
                        <div class="col-md-4">
                            <!-- NA -->
                        </div>
                        
                        <div class="col-md-4">
                            <!-- NA -->
                        </div>
                    </div>
                </div>              
            </div>

            <div class="card-body border-top">
            <form  action="{{ route('admins.clients.destroy', $data['client']->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger">{{ __('lang.delete') }}</button>
            </form>
            </div>
        </div>

    </div>
    
</div>

@endsection