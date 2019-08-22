@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row mr-auto">
            <div class="col-md-8">
                <ul class="nav nav-pills" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="item-list-tab" data-toggle="tab" href="#item-list" role="tab" aria-controls="item-list" aria-selected="true">Item List</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Daily Audit</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" id="daily-audit-items-tab" data-toggle="tab" role="tab" aria-controls="daily-audit-items" aria-selected="false" href="#daily-audit-items">Items</a>
                            <a class="dropdown-item" id="daily-audit-sales-tab" data-toggle="tab" role="tab" aria-controls="daily-audit-sales" aria-selected="false" href="#daily-audit-sales">Sales</a>
                            <a class="dropdown-item" id="daily-audit-purchases-tab" data-toggle="tab" role="tab" aria-controls="daily-audit-purchases" aria-selected="false" href="#daily-audit-purchases">Purchases</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="market-analytics-tab" data-toggle="tab" href="#market-analytics" role="tab" aria-controls="market-analytics" aria-selected="false">Market Analytics</a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="item-list" role="tabpanel" aria-labelledby="item-list">@include('partials.item-list')</div>
                    <div class="tab-pane fade" id="daily-audit-items" role="tabpanel" aria-labelledby="daily-audit-items">@include('partials.daily-audit-items')</div>
                    <div class="tab-pane fade" id="daily-audit-sales" role="tabpanel" aria-labelledby="daily-audit-sales">@include('partials.daily-audit-sales')</div>
                    <div class="tab-pane fade" id="daily-audit-purchases" role="tabpanel" aria-labelledby="daily-audit-purchases">@include('partials.daily-audit-purchases')</div>
                    <div class="tab-pane fade" id="market-analytics" role="tabpanel" aria-labelledby="market-analytics">@include('partials.market-analytics')</div>

                </div>
            </div>
        </div>
    </div>
    <script language="JavaScript">
        $('#item_list_search').on('keyup', function() {
            let query = $(this).val();
            if (query.length > 2) {
                fetch_item_data(query);
            }
        });


        function fetch_item_data(query = '')
        {
            $('tbody').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
            jQuery.ajax({
                url:"/items/search",
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    console.log(data.table_data);
                    $('tbody').html(data.table_data);
                    $('#total_records').text(data.total_data);
                    $('#modals').html(data.modal_data);
                }
            });
        }

    </script>

@endsection
