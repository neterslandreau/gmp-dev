<div class="container">

    <div class="row">

        <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="item-table">
            <tr>
                <th>Slug</th>
                <th>Name</th>
                <th>UPC Code</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Net Case</th>
                <th>Net Cost</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($items as $key => $item)
                <tr id="item_{{ $item->id }}">
                    <td>{{ $item->slug }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->upc_code }}</td>
                    <td>{{ $item->size }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->net_case }}</td>
                    <td>{{ $item->net_cost }}</td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemmodal_{{ $item->id }}">View</button>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $items->links() }}
    </div>

</div>
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach

