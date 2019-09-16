@extends('layouts.app')
@php

    $user = session()->get('user');
    $stores = $user->stores;
    $store_nbr = str_pad(session()->get('store')->number, 4, 0,STR_PAD_LEFT);
    $sales = App\Sales::where('store_nbr', '=', $store_nbr)->where('sale_date', '!=', '')->paginate(5);
//    dd($sales);
//    $store_nbr = str_pad(session()->get('store')->number, 4, 0,STR_PAD_LEFT);
//    $items = App\Item::where('store_nbr', '=', $store_nbr)->paginate(5);

@endphp
@section('content')

    @include('navigation.body-nav')

    @include('partials.daily-audit-sales2')

@endsection
