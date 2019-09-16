
$(function() {

    $('[id^="usersave_"]').on('click', function () {

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
        $.each(storesArr, function (k, v) {
            console.log('v:' + v);
            // console.log('checked',$('#user_'+user_id+'_store_'+v+':checked').length);
            if ($('#user_' + user_id + '_store_' + v + ':checked').length > 0) {
                stores_out.push(v);
            }

        });

        console.log(stores_out);

        let url = '/users/' + user_id + '/update';

        let verified_at = $('#email_verified_at_' + user_id).val();

        if ($('#verified_' + user_id).is(':checked') === true) {
            let d = new Date();
            let ds = d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2) + ' ' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2);

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

    $('[id^="storesave_"]').on('click', function () {

        let store_id = this.id.split('_')[1];

        let form = $('#form_' + store_id);

        console.log('form: ', form.serialize());

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

    // $('a[data-toggle="tab"]').on('click', function (e) {
    //     window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    // });
    // let activeTab = window.localStorage.getItem('activeTab');
    // if (activeTab) {
    //     $('#myTab a[href="' + activeTab + '"]').tab('show');
    // }



    $('#item-list-tab').on('click', function() {
        console.log(window.location.href);
        $('.nav-link').removeClass('active');
        $('#item-list-tab').addClass('active');
    });

    $('#daily-audit-sales-tab').on('click', function() {
        $('.nav-link').removeClass('active');
        $('#daily-audit-sales-tab').addClass('active');
    });

    $('#daily-audit-purchases-tab').on('click', function() {
        $('.nav-link').removeClass('active');
        $('#daily-audit-purchases-tab').addClass('active');
    });

    $('#market-analytics-tab').on('click', function() {
        $('.nav-link').removeClass('active');
        $('#market-analytics-tab').addClass('active');
    });

    $('#store-config-tab').on('click', function() {
        $('.nav-link').removeClass('active');
        $('#store-config-tab').addClass('active');
    });

    // $('#daily-audit-items-tab').on('click', function () {
    //     console.log('daily audit items clicked');
    //     // console.log('store-select',$('#store_id').html());
    //
    //     let data = {
    //         store_id: $('#store_id').html(),
    //         delivery_date: $('#delivery_date').html()
    //     };
    //
    //     let url = '/invoices/' + $('#store_id').html() + '/' + $('#delivery_date').html() + '/get';
    //
    //     console.log('url', url);
    //
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //
    //     console.log('posting data ', data);
    //
    //     $.post(url, data, function (response, status) {
    //         console.log(response);
    //         console.log(status);
    //     });
    //
    // });

    $("#ex12a").slider({id: "slider12a", min: 0, max: 10, value: 5});
    $("#ex12b").slider({id: "slider12b", min: 0, max: 10, range: true, value: [3, 7]});
    $("#ex12c").slider({id: "slider12c", min: 0, max: 10, range: true, value: [3, 7]});

    $('#item_list_search').on('keyup', function () {
        let query = $(this).val();
        fetch_item_data(query);
    });

    $('#sales_list_search').on('keyup', function () {
        let query = $(this).val();
        fetch_sales_data(query);
    });

    $('#store-select-store').on('change', function () {
        console.log($(this).val());
        let store_id = $(this).val();
        $.ajax({
            url: '/invoices/get_delivery_dates',
            method: 'POST',
            data: {
                _token: Laravel.csrfToken,
                'store_id': store_id
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);
                $.each(data, function (index, val) {
                    console.log(val);
                    $('#deldates-store').append('<option value=' + val + ' name=' + val + '>' + val + '</option>');
                });
                $('#deldates-store').removeAttr('disabled');
            }

        });
    });

    $('#store-select-home').on('change', function () {
        console.log($(this).val());
        let store_id = $(this).val();
        $.ajax({
            url: '/invoices/get_delivery_dates',
            method: 'POST',
            data: {
                _token: Laravel.csrfToken,
                'store_id': store_id
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);
                $.each(data, function (index, val) {
                    console.log(val);
                    $('#deldates-home').append('<option value=' + val + ' name=' + val + '>' + val + '</option>');
                });
                $('#deldates-home').removeAttr('disabled');
            }

        });
    });

    $('#item-list-tab').on('click', function () {
        let store_nbr = $('#store_number').html();
        $('#item-table').contents('tbody').html('<tr><td><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        $.ajax({
            url: '/items/get_by_store',
            method: 'POST',
            data: {
                _token: Laravel.csrfToken,
                'store_nbr': store_nbr
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);
                $('#total_records').html(data.total);
                $('#item-list-details-holder').removeClass('d-none');

                $('#item-table').contents('thead').html(
                    '<tr>' +
                    '<th>Store</th>' +
                    '<th>UPC/PLU</th>' +
                    '<th>Description</th>' +
                    '<th>Qty Sold</th>' +
                    '<th>Amt Sold</th>' +
                    '<th>Weight Sold</th>' +
                    '<th>Sale Date</th>' +
                    '<th>Price Qty</th>' +
                    '<th>Price</th>' +
                    '<th>Unit Cost</th>' +
                    '<th>Size</th>' +
                    '<th>Case Cost</th>' +
                    '<th>Cur Price Qty</th>' +
                    '<th>Cur Price</th>' +
                    '<th>Base Unit Cost</th>' +
                    '<th>Base Case Cost</th>' +
                    '<th>Action</th>' +
                    '</tr>');
                $('#item-table').contents('tbody').html('');
                $.each(data.data, function (index, val) {
                    $('#item-table').contents('tbody').append('<tr id="item_' + val.id + '" class="items-tr" data-toggle="modal" data-target="#itemmodal_' + val.id + '">');
                    $('#item-table').contents('tbody').append('<td >' + val.store_nbr + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.upc_code + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.pos_description + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.qty_sold + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.amt_sold + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.weight_sold + '</td>');
                    $('#item-table').contents('tbody').append('<td ></td>');
                    $('#item-table').contents('tbody').append('<td >' + val.price_qty + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.price + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.unit_cost + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.size + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.case_cost + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.cur_price_qty + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.cur_price + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.base_unit_cost + '</td>');
                    $('#item-table').contents('tbody').append('<td >' + val.base_case_cost + '</td>');
                    $('#item-table').contents('tbody').append('<td ><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemmodal_' + val.id + '">View</button></td>');
                    $('#item-table').contents('tbody').append('</tr>');
                });
            }

        });
    });

    $('#daily-audit-sales-tab').on('click', function () {
        let store_nbr = $('#store_number').html();
        $('#sales-table').contents('tbody').html('<tr><td><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        $.ajax({
            url: '/sales/get_by_store',
            method: 'POST',
            data: {
                _token: Laravel.csrfToken,
                'store_nbr': store_nbr
            },
            dataType: 'json',


            success: function (data) {
                console.log(data);
                $('#total_records_sales').html(data.length);
                $('#sales-list-details-holder').removeClass('d-none');

                $('#sales-table').contents('thead').html(
                    '<th>PLU</th>' +
                    '<th>Description</th>' +
                    '<th>Qty</th>' +
                    '<th>Amount $</th>' +
                    '<th>Wt Sold</th>' +
                    '<th>Prc/Unit</th>' +
                    '<th>Action</th>'
                );
                $('#sales-table').contents('tbody').html('');

                $.each(data, function(index, val) {
                    $('#sales-table').contents('tbody').append('<tr id="item_' + val.id + '" class="sales-tr" data-toggle="modal" data-target="#salesmodal_' + val.id + '">');

                    $('#sales-table').contents('tbody').append('<td>' + val.upc_code + '</td>');
                    $('#sales-table').contents('tbody').append('<td>' + val.pos_description + '</td>');
                    $('#sales-table').contents('tbody').append('<td>' + val.qty_sold + '</td>');
                    $('#sales-table').contents('tbody').append('<td>' + val.amt_sold + '</td>');
                    $('#sales-table').contents('tbody').append('<td>' + val.weight_sold + '</td>');
                    $('#sales-table').contents('tbody').append('<td>' + val.unit_cost + '</td>');
                    $('#sales-table').contents('tbody').append('<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salesmodal_' + val.id + '">View</button></td>');

                    $('#sales-table').contents('tbody').append('</tr>');

                    $('#sales-modals').append(
                        '<div class="modal fade" id="salesmodal_' +  val.id + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\n' +
                        '<div class="modal-dialog" role="document">\n' +
                        '<div class="modal-content">\n' +
                        '<div class="modal-header">\n' +
                        '<h5 class="modal-title" id="modal_' +  val.id + '">' +  val.name + '</h5>\n' +
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
                        '<span aria-hidden="true">&times;</span>\n' +
                        '</button>\n' +
                        '</div>\n' +
                        '<div class="modal-body">\n' +
                        '<form id="form_' +  val.id + '">\n' +
                        '<div class="form-group">\n' +
                        '<label for="' +  val.pos_description + '">Description</label>\n' +
                        '<input type="text" name="name" class="form-control" value="' +  val.pos_description + '" readonly>\n' +
                        '</div>\n' +
                        '<div class="form-group">\n' +
                        '<label for="' +  val.upc_code + '">UPC Code</label>\n' +
                        '<input type="text" name="upc_code" class="form-control" value="' +  val.upc_code + '" readonly>\n' +
                        '</div>\n' +
                        '<div class="form-group">\n' +
                        '<label for="' +  val.quantity_sold + '">Quantity Sold</label>\n' +
                        '<input type="text" name="size" class="form-control" value="' +  val.quantity_sold + '" readonly>\n' +
                        '</div>\n' +
                        '<div class="form-group">\n' +
                        '<label for="' +  val.weight_sold + '">Weight Sold</label>\n' +
                        '<input type="text" name="quantity" class="form-control" value="' +  val.weight_sold + '" readonly>\n' +
                        '</div>\n' +
                        '<div class="form-group">\n' +
                        '<label for="' +  val.unit_cost + '">Prc/Unit</label>\n' +
                        '<input type="text" name="net_case" class="form-control" value="' +  val.unit_cost + '" readonly>\n' +
                        '</div>\n' +
                        '</form>\n' +
                        '</div>\n' +
                        '<div class="modal-footer">\n' +
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>\n' +
                        '<button type="button" class="btn btn-primary" id="itemsave_' +  val.id + '">Save changes</button>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</div>\n');

                });

            }

        });
    });

    $('#daily-audit-purchases-tab').on('click', function() {
        let store_id = $('#store_id').html();
        let delivery_date = $('#delivery_date').html();
        $('#purchases-table').contents('thead').html('<tr><td><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        $.ajax({
            url: '/invoices/get_by_store',
            method: 'POST',
            data: {
                _token: Laravel.csrfToken,
                'store_id': store_id,
                'delivery_date': delivery_date
            },
            dataType: 'json',


            success: function (data) {

                console.log(data);

                $('#total_records_purchases').html(data.length);
                $('#purchases-list-details-holder').removeClass('d-none');
                $('#purchases-table').contents('thead').html('');

                $('#purchases-table').contents('thead').append('<tr>');
                $('#purchases-table').contents('thead').append('<th>UPC/PLU</th>');
                $('#purchases-table').contents('thead').append('<th>Description</th>');
                $('#purchases-table').contents('thead').append('<th>Cases</th>');
                $('#purchases-table').contents('thead').append('<th>Items/Case</th>');
                $('#purchases-table').contents('thead').append('<th>Case Cost</th>');
                $('#purchases-table').contents('thead').append('<th>Item Cost</th>');
                $('#purchases-table').contents('thead').append('<th>Store</th>');
                $('#purchases-table').contents('thead').append('<th>Action</th>');
                $('#purchases-table').contents('thead').append('</tr>');

                $.each(data, function (index, val) {

                    $('#purchases-table').contents('tbody').append('<tr id="item_' + val.id + '" data-toggle="modal" data-target="#purchasemodal_' + val.id + '">');

                    $('#purchases-table').contents('tbody').append('<td>' + val.upc_code + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + val.item_desc + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + '&nbsp;' + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + val.pack + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + val.pack +  '/ ' + val.mbr_case_cost  + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + val.pack + '/ ' + val.mbr_ext_case_cost + '</td>');
                    $('#purchases-table').contents('tbody').append('<td>' + val.store_nbr + '</td>');
                    $('#purchases-table').contents('tbody').append('<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#purchasemodal_' + val.id + '">View</button></td>');

                    $('#purchases-table').contents('tbody').append('</tr>');

                    $('#purchases-modals').append('<div class="modal fade" id="purchasemodal_' + val.id + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">' +
                        '<div class="modal-dialog" role="document">' +
                        '<div class="modal-content">' +
                        '<div class="modal-header">' +
                        '<h5 class="modal-title" id="purchasemodal_' + val.id + '">' + val.item_desc + '</h5>' +
                        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '</div>' +
                        '<div class="modal-body">' +
                        '<form id="form_' + val.id + '">' +
                        '<div class="form-group">' +
                        '<label for="' + val.item_desc + '">Name</label>' +
                        '<input type="text" name="name" class="form-control" value="' + val.item_desc + '" readonly>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="' + val.upc_code + '">UPC Code</label>' +
                        '<input type="text" name="upc_code" class="form-control" value="' + val.upc_code + '" readonly>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="' + val.size + '">Size</label>' +
                        '<input type="text" name="size" class="form-control" value="' + val.size + '" readonly>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="' + val.mbr_case_cost + '">Quantity</label>' +
                        '<input type="text" name="quantity" class="form-control" value="' + val.mbr_case_cost + '" readonly>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="' + val.mbr_case_cost + '">Case Cost</label>' +
                        '<input type="text" name="net_case" class="form-control" value="' + val.mbr_case_cost + '" readonly>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label for="' + val.mbr_case_cost + '">Net Cost</label>' +
                        '<input type="text" name="net_cost" class="form-control" value="' + val.mbr_case_cost + '" readonly>' +
                        '</div>' +
                        '</form>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>' +
                        '<button type="button" class="btn btn-primary" id="itemsave_' + val.id + '">Save changes</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
                });
            }
        });
    });



});

function fetch_item_data(query = '')
{
    $('#item-table2').contents('tbody').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
    $.ajax({
        url:"/items/search",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
            // console.log(data);
            $('#item-table2').contents('tbody').html(data.table_data);
            $('#total_records').html(data.total_data);
            $('#item-modals').html(data.modal_data);
        }
    });
}

function fetch_sales_data(query = '')
{
    $('#sales-table').contents('tbody').html('<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
    $.ajax({
        url:"/sales/search",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
            // console.log(data);
            $('#sales-table').contents('tbody').html(data.table_data);
            $('#total_records_sales').text(data.total_data);
            $('#sales-modals').html(data.modal_data);
        }
    });

}

function getSales() {
    console.log('getting sales');
}

