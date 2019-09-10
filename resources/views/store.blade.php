@extends('layouts.app')
@section('content')
    <div class="container">

        <form id="store-select-form" method="post" action="/store" class="form-inline">
            {{ csrf_field() }}

            <select class="custom-select" id="store-select-store" name="selected-store">

                <option value="" selected>Select your store</option>

                @foreach($stores as $s => $store)

                    <option id="{{ $store->id }}" value="{{ $store->id }}">{{ $store->name }}</option>

                @endforeach

            </select>

            <select class="custom-select" id="deldates-store" name="delivery_date" disabled>
                <option value="" selected>Select your date</option>


            </select>

            <button type="submit" class="btn btn-outline-info">Go</button>
        </form>

    </div>
@endsection
