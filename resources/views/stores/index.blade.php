@extends('layouts.app')


@section('content')
    <div id="stores-index">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Stores Management</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('stores.create') }}"> Create New Store</a>
                </div>
            </div>
        </div>


        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif


        <table class="table table-bordered table-condensed table-striped table-hover" id="store-table">
            <tr>
                <th>No</th>
                <th>Store Name</th>
                <th>Store Type</th>
                <th>Store Manager</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($stores as $key => $store)
                <tr id="store_{{ $store->id }}">
                    <td>{{ ++$key }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->store_format->name }}</td>
                    <td>{{ $store->manager['first_name'] }} {{ $store->manager['last_name'] }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#storemodal_{{ $store->id }}">View</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    @foreach ($stores as $key => $store)
        @include('partials.modals.storemodal')
    @endforeach

@endsection
