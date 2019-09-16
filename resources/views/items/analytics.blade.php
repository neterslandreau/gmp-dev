@extends('layouts.app')
@php

    $user = session()->get('user');
    $stores = $user->stores;
//    $sales = App\Sales::where('store_nbr', '=', str_pad(request('store_nbr'), 4, '0', STR_PAD_LEFT))->where('sale_date', '!=', '')->get();
    $store_nbr = str_pad(session()->get('store')->number, 4, 0,STR_PAD_LEFT);
    $items = App\Item::where('store_nbr', '=', $store_nbr)->paginate(5);

@endphp
@section('content')

    @include('navigation.body-nav')

    @include('partials.market-analytics')

@endsection
