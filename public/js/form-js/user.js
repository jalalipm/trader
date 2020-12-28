/********************************************* Open Modal Address **************************************************/
let mToken = $('meta[name="csrf-token"]').attr('content');

$('body').on('click', '.open-address-user-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#user-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#user-modal').modal('show');
});
/********************************************* Open Modal Add/Edit **************************************************/
$('body').on('click', '.open-user-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    // alert(url);
    $('#user-modal-title').html("جزییات - کاربر");
    $('#user-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    //alert(me.hasClass('edit'));
    //alert(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#user-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#user-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#user-save-btn').click(function(event) {
    event.preventDefault();

    let form = $('#user-modal-body form');
    let url = form.attr('action');
    // let method = $('#user-modal-body input[name=_method]').val() == undefined ? 'POST' : 'PUT';  // complex way , for create and update
    //alert(method);
    //alert(url);

    //reset error message
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response == 'create') {
                //alert('ok');
                $('#user-modal').modal('hide');
                iziToast.success({
                    title: 'ایجاد',
                    message: 'کاربر جدید با موفقیت ایجاد شد.',
                    position: 'bottomLeft'
                });
            } else {
                //alert('nok');
                $('#user-modal').modal('hide');
                iziToast.success({
                    title: 'ویرایش',
                    message: 'اطلاعات با موفقیت ویرایش شد.',
                    position: 'bottomLeft'
                });
            }
            reloadTable();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            //console.log(xhr);
            if ($.isEmptyObject(errors) == false) {
                $.each(errors, function(key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-danger')
                        .append('<span class="danger help-block">' + value + '</span>');
                });
            }
        }
    });
});
/********************************************* Fill DataTable User******************************************/
let url = $('#user-table').attr('data-route');

function separator(d) {
    let num = d.substr(0, d.indexOf('.'));
    if (num.length > 3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    return num;
}

function format(d) {
    // `d` is the original data object for the row
    // var num = d.wallet.substr(0,d.wallet.indexOf('.'));
    // if(num.length>3)
    //     num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    // d.wallet = num;
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>پست الکترونیک:</td>' +
        '<td>' + (d.email == null ? ' - ' : d.email) + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td> آدرس: </td>' +
        '<td>' + (d.address == null ? ' - ' : d.address) + '</td>' +
        '<td> کد پستی: </td>' +
        '<td>' + (d.postal_code == null ? ' - ' : d.postal_code) + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [{
                "className": 'details-control',
                orderable: false,
                "data": null,
                "defaultContent": '',
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'cell_phone',
                name: 'cell_phone'
            },
            {
                data: 'national_code',
                name: 'national_code'
            },
            {
                data: 'status_title',
                name: 'status_title'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
        buttons: [datatableButton],
        "language": datatableLanguage
    });
    $('#user-table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});

/******************************************** Delete Row **************************************************/
$('body').on('click', '.delete_row', function(event) {
    event.preventDefault();
    let me = $(this);
    let url = me.attr('data-route');
    iziToast.show({
        theme: 'dark',
        icon: 'icon-person',
        title: 'حذف',
        message: 'آیا مطمئن هستید؟',
        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
            ['<button>بله</button>', function(instance, toast) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'delete',
                        _token: mToken
                    },
                    success: function(resp) {
                        iziToast.success({
                            title: 'حذف',
                            message: 'سطر مورد نظر با موفقیت حذف شد.',
                            position: 'bottomLeft'
                        });
                    },
                    error: function(e) {
                        iziToast.error({
                            title: 'حذف',
                            message: 'عملیات با خطا مواجه شد.',
                            position: 'bottomLeft'
                        });
                    }
                });
                reloadTable();
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy) {
                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                    }
                }, toast, 'buttonName');
            }, true], // true to focus
            ['<button>خیر</button>', function(instance, toast) {
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy) {
                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                    }
                }, toast, 'buttonName');
            }]
        ],
        onOpening: function(instance, toast) {
            console.info('callback abriu!');
        },
        onClosing: function(instance, toast, closedBy) {
            console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
        }
    });
});
/****************************************** Reload DataTable **********************************************/
function reloadTable() {
    var table = $('#user-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/