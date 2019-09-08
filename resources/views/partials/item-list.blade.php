<div class="container">

    <div class="row">

        <div class="form-group pt-3">
            <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Items" />
        </div>

        <div class="">
            <h3 class="d-block">Total Items: <span id="total_records"></span></h3>
{{-- --}}
            <table class="table table-bordered table-sm table-condensed table-striped table-hover items-table" id="item-table">
                <thead>
                    <tr>
                        <th>Store</th>
                        <th>UPC/PLU</th>
                        <th>Description</th>
                        <th>Qty Sold</th>
                        <th>Amt Sold</th>
                        <th>Weight Sold</th>
                        <th>Sale Date</th>
                        <th>Price Qty</th>
                        <th>Price</th>
                        <th>Unit Cost</th>
                        <th>Size</th>
                        <th>Case Cost</th>
                        <th>Cur Price Qty</th>
                        <th>Cur Price</th>
                        <th>Base Unit Cost</th>
                        <th>Base Case Cost</th>
{{--                        <th>Action</th>--}}
                    </tr>
                </thead>
                <tbody>
                @foreach ($items as $key => $item)
                    <tr id="item_{{ $item->id }}" class="items-tr" data-toggle="modal" data-target="#itemmodal_{{ $item->id }}">
                        <td>{{ $item->store_nbr }}</td>
                        <td>{{ $item->upc_code }}</td>
                        <td>{{ $item->pos_description }}</td>
                        <td>{{ $item->qty_sold }}</td>
                        <td>{{ $item->amt_sold }}</td>
                        <td>{{ $item->weight_sold }}</td>
                        <td>{{ $item->sale_date }}</td>
                        <td>{{ $item->price_qty }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->unit_cost }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->case_cost }}</td>
                        <td>{{ $item->cur_price_qty }}</td>
                        <td>{{ $item->cur_price }}</td>
                        <td>{{ $item->base_unit_cost }}</td>
                        <td>{{ $item->base_case_cost }}</td>
{{--                        <td>--}}
{{--                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemmodal_{{ $item->id }}">View</button>--}}
{{--                        </td>--}}
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
<div id="item-modals">
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach
</div>
