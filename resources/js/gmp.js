$(function() {


    $('[id^="usersave_"]').on('click', function() {

        let user_id = this.id.split('_')[1];

        let form = $('#form_' + user_id);

        let geturl = '/get_ids';

        let storesArr;

        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': geturl,
            'data': {
                _token: Laravel.csrfToken
            },
            'success': function (data) {
                storesArr = data;
            }
        });

        let stores_out = [];
        $.each(storesArr, function(k, v) {
            console.log('v:'+v);
            // console.log('checked',$('#user_'+user_id+'_store_'+v+':checked').length);
            if ($('#user_'+user_id+'_store_'+v+':checked').length > 0) {
                stores_out.push(v);
            }

        });

         console.log(stores_out);

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // console.log('posting data ',data);

        $.ajax({
            'async': true,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': url,
            'data': {
                id: user_id,
                role: $('#role_' + user_id).val(),
                email_verified_at: verified_at,
                stores: stores_out,
                _token: Laravel.csrfToken
            },
            'success': function (data) {
                console.log(data);
                location.reload();
            }
        });
    });

    $('[id^="storesave_"]').on('click', function() {

        let store_id = this.id.split('_')[1];

        let form = $('#form_' + store_id);

        console.log('form: ',form.serialize());

        let mydata = form.serialize();
        let mydata_arr = mydata.split('&');
        let mym = mydata_arr[1].split('=');
        let myt = mydata_arr[2].split('=');

        console.log(mym[1].length);

        if (mym[1].length > 0) {
            let manager_id = mym[1];
        } else {
            let manager_id = null;
        }

        console.log(mydata_arr[2]);

        let url = '/stores/' + store_id + '/update';
        let data = {
            id: store_id,
            store_id: store_id,
            manager_id: manager_id,
            store_format_id: myt[1],

            _token: Laravel.csrfToken
        };

        console.log(data);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'async': true,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': url,
            'data': data,
            'success': function (data) {
                console.log(data);
                location.reload();
            }
        });

    });

    $('a[data-toggle="tab"]').on('click', function(e) {
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    let activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }

    $('#daily-audit-items-tab').on('click', function() {
        console.log('daily audit items clicked');
        // console.log('store-select',$('#store_id').html());

        let data = {
            store_id: $('#store_id').html(),
            delivery_date: $('#delivery_date').html()
        };

        let url = '/invoices/'+$('#store_id').html()+'/'+$('#delivery_date').html()+'/get';

        console.log('url', url);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('posting data ',data);

        $.post(url, data, function (response, status) {
            console.log(response);
            console.log(status);
        });

    });

    $("#ex12a").slider({ id: "slider12a", min: 0, max: 10, value: 5 });
    $("#ex12b").slider({ id: "slider12b", min: 0, max: 10, range: true, value: [3, 7] });
    $("#ex12c").slider({ id: "slider12c", min: 0, max: 10, range: true, value: [3, 7] });

    $('#item_list_search').on('keyup', function() {
        let query = $(this).val();
        if (query.length > 2) {
            fetch_item_data(query);
        }
    });

});

function fetch_item_data(query = '')
{
    $('tbody').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
    jQuery.ajax({
        url:"/items/search",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
            console.log(data.table_data);
            $('tbody').html(data.table_data);
            $('#total_records').text(data.total_data);
            $('#modals').html(data.modal_data);
        }
    });
}

function getSales() {
    console.log('getting sales');
}


