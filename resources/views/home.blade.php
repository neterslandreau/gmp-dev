@extends('layouts.app')
@section('content')
@php
    $user = session()->get('user');
    $stores = $user->stores;
@endphp
    <div class="container">

        <div class="row mr-auto">
            <div class="col-md-8">

                <h5>Store: {{ session()->get('store')->name }}  -  Delivery Date: {{ session()->get('delivery_date') }}</h5>
                <div id="store_id" class="d-none">{{ session()->get('store')->id }}</div>
                <div id="store_number" class="d-none">{{ session()->get('store')->number }}</div>
                <div id="delivery_date" class="d-none">{{ session()->get('delivery_date') }}</div>

                <div class="pb-3">

                    <form id="store-select-form-home" method="post" action="/store" class="form-inline">
                        {{ csrf_field() }}

                        <select class="custom-select" id="store-select-home" name="selected-store">

                            <option value="" selected>Select your store</option>

                            @foreach($stores as $s => $store)

                                <option id="{{ $store->id }}" value="{{ $store->id }}">{{ $store->name }}</option>

                            @endforeach

                        </select>

                        <select class="custom-select" id="deldates-home" name="delivery_date" disabled>
                            <option value="" selected>Select your date</option>


                        </select>

                        <input type="hidden" name="from_home" value="1">

                        <button id="select-store-date" type="submit" class="btn btn-outline-info">Go</button>
                    </form>

                </div>


                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="item-list-tab" data-toggle="tab" href="#item-list" role="tab" aria-controls="item-list" aria-selected="true">Your Item List</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Daily Audit</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" id="daily-audit-sales-tab" data-toggle="tab" role="tab" aria-controls="daily-audit-sales" aria-selected="false" href="#daily-audit-sales">Sales</a>
                            <a class="dropdown-item" id="daily-audit-purchases-tab" data-toggle="tab" role="tab" aria-controls="daily-audit-purchases" aria-selected="false" href="#daily-audit-purchases">Purchases</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="market-analytics-tab" data-toggle="tab" href="#market-analytics" role="tab" aria-controls="market-analytics" aria-selected="false">Market Analytics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="store-config-tab" data-toggle="tab" href="#store-config" role="tab" aria-controls="store-config" aria-selected="false">Store Configuration</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="item-list" role="tabpanel" aria-labelledby="item-list"> @include('partials.item-list') </div>
                    <div class="tab-pane fade" id="daily-audit-items" role="tabpanel" aria-labelledby="daily-audit-items">{{-- @include('partials.daily-audit-items') --}}</div>
                    <div class="tab-pane fade" id="daily-audit-sales" role="tabpanel" aria-labelledby="daily-audit-sales">{{-- @include('partials.daily-audit-sales') --}}</div>
                    <div class="tab-pane fade" id="daily-audit-purchases" role="tabpanel" aria-labelledby="daily-audit-purchases">{{-- @include('partials.daily-audit-purchases') --}}</div>
                    <div class="tab-pane fade" id="market-analytics" role="tabpanel" aria-labelledby="market-analytics">{{-- @include('partials.market-analytics') --}}</div>
                    <div class="tab-pane fade" id="store-config" role="tabpanel" aria-labelledby="store-config">{{-- @include('partials.store-config') --}}</div>

                </div>
            </div>
        </div>
    </div>

@endsection
