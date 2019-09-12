@php
//    $store_nbr = session()->get('store')->number;
//    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);
//    $sales = App\Sales::where('store_nbr', $store_nbr)->get();

@endphp
<div class="container">

    <div id="sales-list-details-holder" class="row d-none">

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="total-sales-holder">
                        <h4 class="text-muted">Total Sales: <span id="total_records_sales"></span></h4>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="sales-list-search-holder">
                        <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Sales" />
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="row">

            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="sales-table">
                <thead>

                </thead>
                <tbody>

                </tbody>
                <tfoot>

                </tfoot>
            </table>

    </div>

</div>
<div id="sales-modals"></div>

