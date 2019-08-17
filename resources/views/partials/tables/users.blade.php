<table class="table table-bordered table-sm table-condensed table-striped table-hover" id="user-table">
    <tr>
        <th>Slug</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Store</th>
        <th>Verified</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($users as $key => $user)
        <tr id="user_{{ $user->id }}">
            <td>{{ $user->slug }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->store }}</td>
            <td>{{ $user->hasVerifiedEmail() }}</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user_modal-{{ $user->id }}">View</button>
            </td>
        </tr>
    @endforeach
</table>
