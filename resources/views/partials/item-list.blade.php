<div class="container">

    <div class="row">

        <div class="form-group">
            <input type="text" name="search" id="item_list_search" class="form-control" placeholder="Search Item Data" />
        </div>

        <div class="table-responsive">
            <h3 class="d-block">Total Data : <span id="total_records"></span></h3>

            <table class="table table-bordered table-sm table-condensed table-striped table-hover" id="item-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>UPC Code</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Net Case</th>
                        <th>Net Cost</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

{{--            {{ $items->links() }}--}}
        </div>
    </div>

</div>
{{--@if (is_array($items))--}}
{{--@foreach ($items as $key => $item)--}}
{{--    @include('partials.modals.itemmodal')--}}
{{--@endforeach--}}
{{--@endif--}}

