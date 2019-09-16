<div class="container">

    <div id="sales-list-details-holder" class="row">

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="total-sales-holder">
                        <h4 class="text-muted">Total Sales: <span id="total_records_sales">{{ $sales->total() }}</span></h4>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="sales-list-search-holder">
                        <input type="text" name="search" id="sales_list_search" class="form-control" placeholder="Search Sales" />
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="sales-table">
            <thead>

            <th>PLU</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Amount $</th>
            <th>Wt Sold</th>
            <th>Prc/Unit</th>
{{--            <th>Action</th>--}}

            </thead>
            <tbody>
            @foreach ($sales as $sale)
            <tr id="sale_{{ $sale->id }}" class="sales-tr" data-toggle="modal" data-target="#salesmodal_{{ $sale->id }}">
                <td>{{ $sale->upc_code }}</td>
                <td>{{ $sale->pos_description }}</td>
                <td>{{ $sale->qty_sold }}</td>
                <td>{{ $sale->amt_sold }}</td>
                <td>{{ $sale->weight_sold }}</td>
                <td>{{ $sale->unit_cost }}</td>
{{--                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salesmodal_{{ $sale->id }}">View</button></td>--}}
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        {!! $sales->render() !!}

    </div>

</div>
<div id="sales-modals">
    @foreach ($sales as $key => $sale)
        @include('partials.modals.salesmodal')
    @endforeach

</div>

