<div class="container">

    <div id="item-list-details-holder" class="row d-none">

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="total-records-holder">
                        <h4 class="text-muted">Total Items: <span id="total_records"></span></h4>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-sm-6">

            <div class="card">
                <div class="card-body">

                    <div id="item-list-search-holder">
                        <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Items" />
                    </div>

                </div>
            </div>

        </div>

    </div>

    <div class="row>">
            <table class="table table-bordered table-sm table-condensed table-striped table-hover items-table" id="item-table">
                <thead>
{{--                <tr>--}}
{{--                    <th>Store</th>--}}
{{--                    <th>UPC/PLU</th>--}}
{{--                    <th>Description</th>--}}
{{--                    <th>Qty Sold</th>--}}
{{--                    <th>Amt Sold</th>--}}
{{--                    <th>Weight Sold</th>--}}
{{--                    <th>Sale Date</th>--}}
{{--                    <th>Price Qty</th>--}}
{{--                    <th>Price</th>--}}
{{--                    <th>Unit Cost</th>--}}
{{--                    <th>Size</th>--}}
{{--                    <th>Case Cost</th>--}}
{{--                    <th>Cur Price Qty</th>--}}
{{--                    <th>Cur Price</th>--}}
{{--                    <th>Base Unit Cost</th>--}}
{{--                    <th>Base Case Cost</th>--}}
{{--                    <th>Action</th>--}}
{{--                </tr>--}}
                </thead>
                <tbody>
                @foreach ($items as $item)
{{--                    <tr class="item_{{ $item->id }}">--}}
{{--                        <td>{{ $item->store_nbr }}</td>--}}
{{--                        <td>{{ $item->upc_code }}</td>--}}
{{--                        <td>{{ $item->pos_description }}</td>--}}
{{--                        <td>{{ $item->qty_sold }}</td>--}}
{{--                        <td>{{ $item->amt_sold }}</td>--}}
{{--                        <td>{{ $item->weight_sold }}</td>--}}
{{--                        <td></td>--}}
{{--                        <td>{{ $item->price_qty }}</td>--}}
{{--                        <td>{{ $item->unit_cost }}</td>--}}
{{--                        <td>{{ $item->size }}</td>--}}
{{--                        <td>{{ $item->case_cost }}</td>--}}
{{--                        <td>{{ $item->cur_price_qty }}</td>--}}
{{--                        <td>{{ $item->cur_price }}</td>--}}
{{--                        <td>{{ $item->base_unit_cost }}</td>--}}
{{--                        <td>{{ $item->base_case_cost }}</td>--}}
{{--                    </tr>--}}
                @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        {!! $items->render() !!}
    </div>

</div>
<div id="item-modals">
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach
</div>
