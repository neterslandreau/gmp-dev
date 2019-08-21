<div class="modal fade" id="itemmodal_{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modal_{{ $item->id }}">{{ $item->name }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="form_{{ $item->id }}">

                    <div class="form-group">

                        <label for="{{ $item->name }}">Name</label>

                        <input type="text" name="name" class="form-control" value="{{ $item->name }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $item->upc_code }}">UPC Code</label>

                        <input type="text" name="upc_code" class="form-control" value="{{ $item->upc_code }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $item->size }}">Size</label>

                        <input type="text" name="size" class="form-control" value="{{ $item->size }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $item->quantity }}">Quantity</label>

                        <input type="text" name="quantity" class="form-control" value="{{ $item->quantity }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $item->net_case }}">Net Case</label>

                        <input type="text" name="net_case" class="form-control" value="{{ $item->net_case }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $item->net_cost }}">Net Cost</label>

                        <input type="text" name="net_cost" class="form-control" value="{{ $item->net_cost }}" readonly>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="itemsave_{{ $item->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
