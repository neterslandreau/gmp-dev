const UserAdminTab = $('#user-admin-tab');
const ItemListTab = $('#item-list-tab');
const classItemList = $('#item-list');
const classUserAdmin = $('#user-admin');
const userTable = $('#user-table');

$(function() {
    $('[id^="save_"]').on('click', function() {
        let user_id = this.id.split('_')[1];

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
            console.log('reloaded');
            console.log('changed classes');
            UserAdminTab.trigger('click');
        });
    });
});

function setTabs() {
    console.log('setting tabs');
    ItemListTab.removeClass('active');
    ItemListTab.removeClass('show');
    UserAdminTab.addClass('active');
    UserAdminTab.addClass('show');
    classItemList.removeClass('active');
    classUserAdmin.addClass('active');


}
