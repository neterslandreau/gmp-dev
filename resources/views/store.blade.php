@extends('layouts.app')
@section('content')
    <div class="container">

        <form id="store-select-form" method="post" action="/store" class="form-inline">
            {{ csrf_field() }}

            <select class="custom-select" id="store-select" name="selected-store">

                <option value="" selected>Select your store</option>

                @foreach($stores as $s => $store)

                    <option id="{{ $store->id }}" value="{{ $store->id }}">{{ $store->name }}</option>

                @endforeach

            </select>

            <button id="select-store" type="submit" class="btn btn-primary">Go</button>
        </form>

    </div>
@endsection
