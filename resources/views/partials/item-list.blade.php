<div class="container">

    <div class="row">

        <div class="form-group">
            <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Item Data" />
        </div>

        <div class="table-responsive">
            <h3 class="d-block">Total Items: <span id="total_records"></span></h3>
{{-- --}}
            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="item-table">
                <thead>
                    <tr>
                        <th>Slug</th>
                        <th>Name</th>
                        <th>UPC Code</th>
                        <th>Size</th>
                        <th>Retail</th>
                        <th>Net Case</th>
                        <th>Net Cost</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($items as $key => $item)
                    <tr id="item_{{ $item->id }}">
                        <td>{{ $item->slug }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->upc_code }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->retail }}</td>
                        <td>{{ $item->net_case }}</td>
                        <td>{{ $item->net_cost }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemmodal_{{ $item->id }}">View</button>
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
<div id="modals">
@foreach ($items as $key => $item)
    @include('partials.modals.itemmodal')
@endforeach
</div>
