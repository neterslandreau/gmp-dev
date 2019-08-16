const UserAdminTab = $('#user-admin-tab');
const ItemListTab = $('#item-list-tab');
const classItemList = $('#item-list');
const classUserAdmin = $('#user-admin');
const userTable = $('#user-table');

$(function() {
    $('[id^="usersave_"]').on('click', function() {

        let user_id = this.id.split('_')[1];

        let form = $('#form_' + user_id);
        console.log(form.serialize());

        let url = '/users/' + user_id + '/update';
        let data = {
            id: user_id,
            _token: Laravel.csrfToken
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('posting to '+url);

        $.post(url, data, function (response, status) {
            console.log(status);
            location.reload();
        });
    });

    $('[id^="storesave_"]').on('click', function() {

        let store_id = this.id.split('_')[1];

        let form = $('#form_' + store_id);
        console.log(form.serialize());

        let url = '/stores/' + store_id + '/update';
        let data = {
            id: store_id,

            _token: Laravel.csrfToken
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post(url, data, function (response, status) {
            console.log(response);
            // location.reload();
        });

    });
});

$(function() {
    $('a[data-toggle="tab"]').on('click', function(e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
        // window.localStorage.removeItem("activeTab");
    }
});
