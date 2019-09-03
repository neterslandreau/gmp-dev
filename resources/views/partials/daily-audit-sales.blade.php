@php
    $store_nbr = session()->get('store')->number;
    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);
    $sales = App\Sales::where('store_nbr', $store_nbr)->get();

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
                <tr>
                    <th>PLU</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Amount $</th>
                    <th>Wt Sold</th>
                    <th>Prc/Unit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($sales as $key => $sale)
                    <tr id="item_{{ $sale->id }}">
                        <td>{{ $sale->upc_code }}</td>
                        <td>{{ $sale->pos_description }}</td>
                        <td>{{ $sale->quantity_sold }}</td>
                        <td>{{ $sale->weight_sold }}</td>
                        <td>{{ $sale->unit_price }} UNIT PRICE</td>
                        <td>{{ $sale->pack }} PACK</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salesmodal_{{ $sale->id }}">View</button>
                        </td>
                    </tr>
                @endforeach

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

