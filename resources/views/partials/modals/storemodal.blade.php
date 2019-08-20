<div class="modal fade" id="storemodal_{{ $store->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modal_{{ $store->id }}">{{ $store->name }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="form_{{ $store->id }}">

                    <div class="form-group">

                        <label for="{{ $store->name }}">Name</label>

                        <input type="text" name="name" class="form-control" value="{{ $store->name }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="store-manager-select">Store Manager</label>

                        {{ $store->manager['first_name'] }}

                        <select class="form-control" id="store-manager-select" name="store-manager">
                            <option></option>

                            @foreach ($users as $u => $user)
                                @if ( ($user->id === $store->manager['id']) && ($store->id === $user->store_id) )
                                    <option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endif
                            @endforeach
                        </select>

{{--                        <input type="text" name="manager_id" class="form-control" value="{{ $store->manager['id'] }}">--}}

                    </div>

                    <div class="form-group">

                        <label for="store-format-select">Store Format</label>

                        <select class="form-control" id="store-format-select" name="store-format">

                            @foreach ($store_formats as $s => $format)
                                @if($format->name === $store->store_format->name)
                                    <option value="{{ $format->id }}"selected>{{ $format->name }}</option>
                                @else
                                    <option value="{{ $format->id }}">{{ $format->name }}</option>
                                @endif

                            @endforeach



                        </select>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="storesave_{{ $store->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
