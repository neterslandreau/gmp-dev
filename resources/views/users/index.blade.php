@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div id="users-index">

            <div class="row">

                <div class="col-sm-12">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="">
                        <h2>User Management</h2>
                    </div>

                    <table class="table table-responsive-sm table-striped table-bordered" id="users-table">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Stores</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>@php $ustores = $user->stores; foreach ($ustores as $store) { echo $store->name.'<br>'; }  @endphp</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#user_modal-{{ $user->id }}">View
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $users->links() }}

                </div>

            </div>

        </div>

    </div>
    @foreach ($users as $key => $user)
        @include('partials.modals.user_modal')
    @endforeach

@endsection
