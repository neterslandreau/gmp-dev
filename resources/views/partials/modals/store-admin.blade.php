<div class="modal fade" id="store-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog mw-100" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="">Store Administration</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">

                @include('partials.tables.stores')

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>
@foreach ($stores as $key => $store)
    @include('partials.modals.storemodal')
@endforeach
