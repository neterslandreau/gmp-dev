const UserAdminTab = $('#user-admin-tab');
const ItemListTab = $('#item-list-tab');
const classItemList = $('#item-list');
const classUserAdmin = $('#user-admin');
const userTable = $('#user-table');

$(function() {
    $('[id^="usersave_"]').on('click', function() {

        let user_id = this.id.split('_')[1];

        let form = $('#form_' + user_id);

        let url = '/users/' + user_id + '/update';

        let verified_at = $('#email_verified_at_' + user_id).val();

        if ($('#verified_' + user_id).is(':checked') === true) {
            let d = new Date();
            let ds = d.getFullYear() + '-' + ('0' + (d.getMonth()+1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2) + ' ' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2);

            if (!verified_at) {
                verified_at = ds;
            }
        } else {
            verified_at = null;
        }

        let data = {
            id: user_id,
            role: $('#role_' + user_id).val(),
            email_verified_at: verified_at,
            _token: Laravel.csrfToken
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('posting data ',data);

        $.post(url, data, function (response, status) {
            console.log(status);
            location.reload();
        });
    });

    $('[id^="storesave_"]').on('click', function() {

        let store_id = this.id.split('_')[1];

        let form = $('#form_' + store_id);
        // console.log(form.serialize());

        let url = '/stores/' + store_id + '/update';
        let data = {
            id: store_id,
            manager_id: $('#store-manager-select :selected').val(),
            store_format_id: $('#store-format-select :selected').val(),

            _token: Laravel.csrfToken
        };

        console.log(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post(url, data, function (response, status) {
            location.reload();
        });

    });
});

$(function() {
    $('a[data-toggle="tab"]').on('click', function(e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    let activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }

    // $('#users-table').

    // $("#users-index").on('click-row.bs.table', function (e, row, $element) {
    //     console.log('element data: ', element.data());
    //     // window.location = $element.data('href');
    // });

});
