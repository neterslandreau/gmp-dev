@php
$purchases = [];
    $store_nbr = session()->get('store')->number;
    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);

    $dailys = \Illuminate\Support\Facades\DB::table('invoice_details')->where('store_nbr', $store_nbr)->get();

@endphp


<div class="container">

    <div class="row">

        <div class="form-group pt-3">
            <input type="text" name="search" id="purchases_list_search" class="form-control" placeholder="Search Purchases" />
        </div>

        <div class="table-responsive">
            <h3 class="d-block">Total Purchases: <span id="total_records_purchases"></span></h3>
            {{-- --}}
            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="purchases-table">
                <thead>
                <tr>
                    <th>UPC/PLU</th>
                    <th>Description</th>
                    <th>Pack</th>
                    <th>Size</th>
                    <th>Retail</th>
                    <th>On Hand</th>
                    <th>Net Case</th>
                    <th>Net Cost</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($dailys as $d => $daily)
                    <tr id="item_{{ $daily->id }}">
                        <td>{{ $daily->upc_code }}</td>
                        <td>{{ $daily->retail_price }}</td>
                        <td>{{ $daily->pack }}</td>
                        <td>{{ $daily->size }}</td>
                        <td>{{ $daily->mbr_case_cost }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salesmodal_{{ $daily->id }}">View</button>
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
<div id="purchases-modals">
    @foreach ($dailys as $key => $purchase)
        @include('partials.modals.purchasesmodal')
    @endforeach
</div>
