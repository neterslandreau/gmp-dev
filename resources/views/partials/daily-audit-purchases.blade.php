@php
$purchases = [];
    $store_nbr = session()->get('store')->number;
    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);

    $dailys = \Illuminate\Support\Facades\DB::table('invoice_details')->where('store_nbr', $store_nbr)->get();
    $totals = \Illuminate\Support\Facades\DB::table('invoice_totals')->where('store_nbr', $store_nbr)->get();

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
                    <th>Cases</th>
                    <th>Items/Case</th>
                    <th>Case Cost</th>
                    <th>Item Cost</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($dailys as $d => $daily)
                    <tr id="item_{{ $daily->id }}" data-toggle="modal" data-target="#salesmodal_{{ $daily->id }}">
                        <td>{{ $daily->upc_code }}</td>
                        <td>{{ $daily->item_desc }}</td>
                        <td>{{ $totals[0]->case_qty_billed }}</td>
                        <td>{{ $daily->pack }}</td>
                        <td>{{ $daily->pack }} / {{ $daily->mbr_case_cost }}</td>
                        <td>{{ $daily->pack }} / {{ $daily->mbr_case_cost }}</td>
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
