<div class="modal fade" id="salesmodal_{{ $purchase->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modal_{{ $purchase->id }}">{{ $purchase->item_desc }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="form_{{ $purchase->id }}">

                    <div class="form-group">

                        <label for="{{ $purchase->item_desc }}">Name</label>

                        <input type="text" name="name" class="form-control" value="{{ $purchase->item_desc }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $purchase->upc_code }}">UPC Code</label>

                        <input type="text" name="upc_code" class="form-control" value="{{ $purchase->upc_code }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $purchase->size }}">Size</label>

                        <input type="text" name="size" class="form-control" value="{{ $purchase->size }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $purchase->mbr_case_cost }}">Quantity</label>

                        <input type="text" name="quantity" class="form-control" value="{{ $purchase->mbr_case_cost }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $purchase->mbr_case_cost }}">Case Cost</label>

                        <input type="text" name="net_case" class="form-control" value="{{ $purchase->mbr_case_cost }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $purchase->mbr_case_cost }}">Net Cost</label>

                        <input type="text" name="net_cost" class="form-control" value="{{ $purchase->mbr_case_cost }}" readonly>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="itemsave_{{ $purchase->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
