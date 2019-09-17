<div class="container">

    <div id="purchases-list-details-holder" class="row">

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="total-purchases-holder">
                        <h4 class="text-muted">Total Purchases: <span id="total_records_purchases">{{ $invoices->total() }}</span></h4>
                    </div>

                </div>
            </div>

        </div>

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
            <tr>
                <td>UPC/PLU</td>
                <td>Description</td>
                <td>Cases</td>
                <td>Items/Case</td>
                <td>Case Cost</td>
                <td>Item Cost</td>
                <td>Store</td>
            </tr>

            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr id="item_{{ $invoice->id }}" data-toggle="modal" data-target="#purchasemodal_{{ $invoice->id }}">
                    <td>{{ $invoice->upc_code }}</td>
                    <td>{{ $invoice->item_desc }}</td>
                    <td></td>
                    <td>{{ $invoice->pack }}</td>
                    <td>{{ $invoice->pack }} / {{ $invoice->mbr_case_cost }}</td>
                    <td>{{ $invoice->pack }} / {{ $invoice->mbr_ext_case_cost }}</td>
                    <td>{{ $invoice->store_nbr }}</td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <div id="rows-render" class="d-none">
                @if (isset($rows))
                {!! $rows->render !!}
                @endif
            </div>

            </tfoot>
        </table>
        <div id="invoices-render">
        {!! $invoices->render() !!}
        </div>
    </div>

</div>

<div id="purchases-modals">
    @foreach ($invoices as $key => $purchase)
        @include('partials.modals.purchasesmodal')
    @endforeach
</div>
