@php
//    $store_nbr = session()->get('store')->number;
//    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);
//    $store_id = session()->get('store')->id;
//    $invoice_date = '2019-09-03';

@endphp


<div class="container">

    <div id="purchases-list-details-holder" class="row d-none">

{{--        <div class="col-sm-6">--}}

{{--            <div class="card">--}}
{{--                <div class="card-body">--}}

{{--                    <div id="total-purchases-holder">--}}
{{--                        <h4 class="text-muted">Total Purchases: <span id="total_records_purchases"></span></h4>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="purchases-list-search-holder">
                        <input type="text" name="search" id="purchases_list_search" class="form-control" placeholder="Search Purchases" />
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="row">

            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="purchases-table">
                <thead>

                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table>

    </div>

</div>

<div id="purchases-modals"></div>
