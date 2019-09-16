@php

    $user = session()->get('user');
    $stores = $user->stores;


@endphp
@extends('layouts.app')

@section('content')

    @include('navigation.body-nav')

    @include('partials.daily-audit-purchases2')

@endsection
