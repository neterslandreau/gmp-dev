@php
//    $store_nbr = session()->get('store')->number;
//    $store_nbr = str_pad($store_nbr, 4,'0', STR_PAD_LEFT);
//    $store_id = session()->get('store')->id;
//    $invoice_date = '2019-09-03';

@endphp


<div class="container">


    <div class="row">

        <div class="form-group pt-3">
            <input type="text" name="search" id="purchases_list_search" class="form-control" placeholder="Search Purchases" />
        </div>

        <div class="">
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
                    <th>Store</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoice->invoiceDetail()->get() as $d => $daily)
                    <tr id="item_{{ $daily->id }}" data-toggle="modal" data-target="#purchasemodal_{{ $daily->id }}">
                        <td>{{ $daily->upc_code }}</td>
                        <td>{{ $daily->item_desc }}</td>
                        <td>{{ $invoice->invoiceTotal->case_qty_billed }}</td>
                        <td>{{ $daily->pack }}</td>
                        <td>{{ $daily->pack }} / {{ $daily->mbr_case_cost }}</td>
                        <td>{{ $daily->pack }} / {{ $daily->mbr_case_cost }}</td>
                        <td>{{ $daily->store_nbr }}</td>
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
{{--    @foreach ($dailys as $key => $purchase)--}}
{{--        @include('partials.modals.purchasesmodal')--}}
{{--    @endforeach--}}
</div>
