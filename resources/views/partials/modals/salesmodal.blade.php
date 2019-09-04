<div class="modal fade" id="salesmodal_{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modal_{{ $sale->id }}">{{ $sale->name }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="form_{{ $sale->id }}">

                    <div class="form-group">

                        <label for="{{ $sale->pos_description }}">Description</label>

                        <input type="text" name="name" class="form-control" value="{{ $sale->pos_description }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $sale->upc_code }}">UPC Code</label>

                        <input type="text" name="upc_code" class="form-control" value="{{ $sale->upc_code }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $sale->quantity_sold }}">Quantity Sold</label>

                        <input type="text" name="size" class="form-control" value="{{ $sale->quantity_sold }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $sale->weight_sold }}">Weight Sold</label>

                        <input type="text" name="quantity" class="form-control" value="{{ $sale->weight_sold }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $sale->unit_cost }}">Prc/Unit</label>

                        <input type="text" name="net_case" class="form-control" value="{{ $sale->unit_cost }}" readonly>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="itemsave_{{ $sale->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
