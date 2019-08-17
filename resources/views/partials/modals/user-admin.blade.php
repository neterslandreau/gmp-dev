<div class="modal fade modal-lg" id="user-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog mw-100" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title" id="">User Administration</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">


                    @include('partials.tables.users')


            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>
@foreach ($users as $key => $user)
    @include('partials.modals.user_modal')
@endforeach
