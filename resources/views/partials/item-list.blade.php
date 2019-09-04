<div class="container">

    <div class="row">

        <div class="form-group pt-3">
            <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Items" />
        </div>

        <div class="table-responsive">
            <h3 class="d-block">Total Items: <span id="total_records"></span></h3>
{{-- --}}
            <table class="table table-bordered table-sm table-condensed table-striped table-hover items-table" id="item-table">
                <thead>
                    <tr>
                        <th>UPC/PLU</th>
                        <th>Description</th>
                        <th>Pack</th>
                        <th>Size</th>
                        <th>Retail</th>
                        <th>On Hand</th>
                        <th>Gross Margin</th>
                        <th>Net Case</th>
                        <th>Net Cost</th>
{{--                        <th>Action</th>--}}
                    </tr>
                </thead>
                <tbody>
                @foreach ($items as $key => $item)
                    <tr id="item_{{ $item->id }}" class="items-tr" data-toggle="modal" data-target="#itemmodal_{{ $item->id }}">
                        <td>{{ str_pad($item->upc_code,15, 0, STR_PAD_LEFT) }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->pack }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->retail }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->gross_margin }}</td>
                        <td>{{ $item->net_case }}</td>
                        <td>{{ $item->net_cost }}</td>
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
<div id="modals">
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach
</div>
