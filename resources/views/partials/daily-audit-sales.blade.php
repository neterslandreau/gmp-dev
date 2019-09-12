@php
//    $store_nbr = session()->get('store')->number;
//    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);
//    $sales = App\Sales::where('store_nbr', $store_nbr)->get();
$sales = [];

@endphp
<div class="container">

    <div class="row">

        <div class="form-group pt-3">
            <input type="text" name="search" id="sales_list_search" class="form-control" placeholder="Search Sales" />
        </div>

        <div class="table">
            <h3 class="d-block">Total Sales: <span id="total_records_sales"></span></h3>
            {{-- --}}
            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="sales-table">
                <thead>

                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                </tfoot>
            </table>
            {{-- --}}

        </div>
    </div>

</div>
<div id="sales-modals">
    @foreach ($sales as $key => $sale)
        @include('partials.modals.salesmodal')
    @endforeach
</div>

