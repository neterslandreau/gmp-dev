<div class="row mr-auto pl-5">
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
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="nav nav-pills" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="item-list-tab" href="/items" role="button" aria-controls="item-list" aria-selected="false">Your Item List</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Daily Audit</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" id="daily-audit-sales-tab" role="button" aria-controls="daily-audit-sales" aria-selected="false" href="/sales">Sales</a>
                        <a class="dropdown-item" id="daily-audit-purchases-tab" role="button" aria-controls="daily-audit-purchases" aria-selected="false" href="/purchases">Purchases</a>
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
</div>
