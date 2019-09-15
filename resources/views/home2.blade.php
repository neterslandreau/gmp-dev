@extends('layouts.app')
@section('content')

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-pills" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="item-list-tab" role="tab" aria-controls="item-list" aria-selected="false">Your Item List</a>
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

        </div>
    </nav>

@endsection
