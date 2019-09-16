@extends('layouts.app')
@php
    $user = session()->get('user');
    $stores = $user->stores;
    $sales = App\Sales::where('store_nbr', '=', str_pad(request('store_nbr'), 4, '0', STR_PAD_LEFT))->where('sale_date', '!=', '')->get();
@endphp
@section('content')

    @include('navigation.body-nav')

@endsection
