@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-uppercase text-primary">
            {{ __('lang.clients') }} 
            <a class="btn btn-primary btn-sm" href="{{ route('admins.clients.create') }}"><i aria-hidden="true" class="fa fa-plus"></i></a>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                    @foreach($data['clients'] as $index_name => $client_group)
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#{{$index_name}}" data-toggle="pill" class="nav-link @if($data['tab'] == $index_name) active @endif "> 
                        <span class="hidden-xs">{{ __('lang.'.$index_name) }}</span> <span class="badge rounded-pill bg-primary" style="font-size: 100%;color:#fff;">{{ $client_group->count() }}</span>
                            </a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content p-3">
                    @foreach($data['clients'] as $index_name => $client_group)
                    <div class="tab-pane @if($data['tab'] == $index_name)) active @endif" id="{{$index_name}}">
                        <div class="table-responsive text-primary">
                        <table class="datatable table">
                            <thead class="thead-primary">
                            <tr>
                                <th scope="col">#</th>
                                <!-- <th scope="col">{{ __('lang.terms_and_conditions') }} {{ __('lang.en') }}</th> -->
                                <th scope="col">{{ __('lang.name') }}</th>
                                <th scope="col">{{ __('lang.phone') }}</th>
                                <th scope="col">{{ __('lang.email') }}</th>
                                <th scope="col">{{ __('lang.expiry') }}</th>
                                <th scope="col">{{ __('lang.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $client_group as $index => $client)
                                <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name}}</td>
                                <td>{{ $client->phone}}</td>
                                <td>{{ $client->email}}</td>
                                <td>{{ $client->expiry_date}}</td>
                                <td> 
                                <a href="{{ route('admins.clients.show', $client->id ) }}" class="btn btn-primary ">{{ __('lang.view') }}</a>
                                <a href="" data-toggle="modal" data-target="#delete-{{$client->id}}" class="btn btn-danger ">{{ __('lang.delete') }}</a>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($data['clients'] as $index_name => $client_group)
    @foreach($client_group as $index => $client)
    <div class="modal fade" id="delete-{{$client->id}}" aria-hidden="true"  style="display: none;" >
        <div class="modal-dialog">
        <div class="modal-content border-danger">
            <form action="{{ route('admins.clients.destroy', $client->id) }}" method="POST" enctype="multipart/form-data" >
            {{ method_field('DELETE') }}
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <div class="modal-header bg-danger">
            <h5 class="modal-title text-white">{{ __('lang.client') }}: {{$client->name}}</h5>

            </div>
            <div class="modal-body">
            {{ __('lang.delete_item_text') }}
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-inverse-danger" data-dismiss="modal"><i class="fa fa-times"></i> {{ __('lang.close') }}</button>
            <button type="submit" class="btn btn-danger"><i class="fa fa-check-square-o"></i> {{ __('lang.save') }} </button>
            </div>
            </form>
        </div>
        </div>
    </div>
    @endforeach
@endforeach

@endsection


@push('footer')

@endpush