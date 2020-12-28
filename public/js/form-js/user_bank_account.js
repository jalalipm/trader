/********************************************* Open Modal Address **************************************************/
let mToken = $('meta[name="csrf-token"]').attr('content');
/********************************************* Open Modal Add/Edit **************************************************/
$('body').on('click', '.open-user_bank_account-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    // alert(url);
    $('#user_bank_account-modal-title').html("جزییات - کاربر");
    $('#user_bank_account-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    //alert(me.hasClass('edit'));
    //alert(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#user_bank_account-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#user_bank_account-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#user_bank_account-save-btn').click(function(event) {
    event.preventDefault();

    let form = $('#user_bank_account-modal-body form');
    let url = form.attr('action');
    //reset error message
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response == 'create') {
                $('#user_bank_account-modal').modal('hide');
                iziToast.success({
                    title: 'ایجاد',
                    message: 'حساب جدید با موفقیت ایجاد شد.',
                    position: 'bottomLeft'
                });
            } else {
                $('#user_bank_account-modal').modal('hide');
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
/********************************************* Fill DataTable user_bank_account******************************************/
let url = $('#user_bank_account-table').attr('data-route');

function separator(d) {
    let num = d.substr(0, d.indexOf('.'));
    if (num.length > 3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    return num;
}

function format(d) {
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
    var table = $('#user_bank_account-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [{
                data: 'account_holder',
                name: 'account_holder'
            },
            {
                data: 'card_number',
                name: 'card_number'
            },
            {
                data: 'bank_name',
                name: 'bank_name'
            },
            {
                data: 'iban',
                name: 'iban'
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
    $('#user_bank_account-table tbody').on('click', 'td.details-control', function() {
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
    var table = $('#user_bank_account-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/