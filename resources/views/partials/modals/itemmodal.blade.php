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

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="itemsave_{{ $item->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
