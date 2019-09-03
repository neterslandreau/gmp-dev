<div class="modal fade" id="user_modal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $user->id }}" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modal_{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <form id="form_{{ $user->id }}">

                    <div class="form-group">

                        <label for="{{ $user->first_name }}">First Name</label>

                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $user->last_name }}">Last Name</label>

                        <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="email">Email</label>

                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" readonly>

                    </div>

                    <div class="form-group">

                        <label for="{{ $user->role }}">Role</label>

                        <input type="text" name="role" class="form-control" value="{{ $user->role }}" id="role_{{ $user->id }}">

                    </div>

                    <div class="form-group">

                        <label for="">Stores</label>

                        @php
                        $ustores = $user->stores;
                        $ustore_ids = [];
                        foreach ($ustores as $us => $ustore) {
                            $ustore_ids[] = $ustore->id;
                        }

                        @endphp

                        @foreach($stores as $s => $store)

                            <div class="form-check">

                                @if (in_array($store->id, $ustore_ids))

                                <input class="form-check-input" type="checkbox" value="{{ $store->id }}" id="user_{{ $user->id }}_store_{{ $store->id }}" checked>

                                @else

                                    <input class="form-check-input" type="checkbox" value="{{ $store->id }}" id="user_{{ $user->id }}_store_{{ $store->id }}">

                                @endif

                                <label class="form-check-label" for="{{ $store->id }}">
                                    {{ $store->name }}
                                </label>
                            </div>

                        @endforeach

{{--                        <!-- Default switch -->--}}
{{--                        <div class="custom-control custom-switch">--}}
{{--                            <input type="checkbox">--}}
{{--                            <label for="customSwitches">Toggle this switch element</label>--}}
{{--                        </div>--}}
{{--                        <select class="custom-select" id="selstores" size="5" name="selected-stores" multiple>--}}
{{--                            @php--}}
{{--                            $ustores = $user->stores;--}}
{{--                            @endphp--}}

{{--                                @foreach($stores as $s => $store)--}}

{{--                                    @if ($store->id)--}}
{{--                                        <option id="{{ $store->id }}" value="{{ $store->id }}" selected>{{ $store->name }} </option>--}}
{{--                                    @else--}}
{{--                                        <option id="{{ $store->id }}" value="{{ $store->id }}">{{ $store->name }} </option>--}}
{{--                                    @endif--}}

{{--                                @endforeach--}}

{{--                        </select>--}}
{{--                        <input type="text" name="role" class="form-control" value="{{ $user->store }}" id="store_{{ $user->id }}">--}}

                    </div>

                    <div class="form-group form-check">

                        @if ($user->hasVerifiedEmail())

                            <input class="form-check-input" type="checkbox" value="{{ $user->hasVerifiedEmail() }}" id="verified_{{ $user->id }}" checked>

                        @else

                            <input class="form-check-input" type="checkbox" value="{{ $user->hasVerifiedEmail() }}" id="verified_{{ $user->id }}">

                        @endif

                        <input type="hidden" name="email_verified_at" value="{{ $user->email_verified_at }}" id="email_verified_at_{{ $user->id }}">

                        <label class="form-check-label">Verified</label>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="usersave_{{ $user->id }}" data-dismiss="modal">Save changes</button>

            </div>

        </div>

    </div>

</div>
