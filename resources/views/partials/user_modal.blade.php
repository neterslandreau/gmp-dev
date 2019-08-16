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

                        <input type="text" name="role" class="form-control" value="{{ $user->role }}">

                    </div>

                    <div class="form-group form-check">

                        @if ($user->hasVerifiedEmail())

                            <input class="form-check-input" type="checkbox" value="{{ $user->hasVerifiedEmail() }}" id="verified_{{ $user->id }}" checked>

                        @else

                            <input class="form-check-input" type="checkbox" value="{{ $user->hasVerifiedEmail() }}" id="verified_{{ $user->id }}">

                        @endif

                        <label class="form-check-label">Verified</label>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="usersave_{{ $user->id }}">Save changes</button>

            </div>

        </div>

    </div>

</div>
