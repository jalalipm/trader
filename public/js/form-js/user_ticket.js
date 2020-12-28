/********************************************* Open Modal Address **************************************************/
let mToken = $('meta[name="csrf-token"]').attr('content');
/********************************************* Open Modal Add/Edit **************************************************/
$('body').on('click', '.open-user_ticket-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    $('#user_ticket-modal-title').html("جزییات - کاربر");
    $('#user_ticket-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            $('#user_ticket-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#user_ticket-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#user_ticket-save-btn').click(function(event) {
    event.preventDefault();

    let form = $('#user_ticket-modal-body form');
    let url = form.attr('action');
    //reset error user_ticket
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');

    $.ajax({
        url: url,
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response == 'create') {
                $('#user_ticket-modal').modal('hide');
                iziToast.success({
                    title: 'ایجاد',
                    user_ticket: 'پیام جدید با موفقیت ایجاد شد.',
                    position: 'bottomLeft'
                });
            } else {
                $('#user_ticket-modal').modal('hide');
                iziToast.success({
                    title: 'ویرایش',
                    user_ticket: 'اطلاعات با موفقیت ویرایش شد.',
                    position: 'bottomLeft'
                });
            }
            reloadTable();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
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
/********************************************* Fill DataTable user_ticket******************************************/
let url = $('#user_ticket-table').attr('data-route');

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td> پیام :</td>' +
        '<td style="white-space: initial;">' + d.comment + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#user_ticket-table').DataTable({
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
                data: 'full_name',
                name: 'full_name',
            },
            {
                data: 'title',
                name: 'title'
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
    $('#user_ticket-table tbody').on('click', 'td.details-control', function() {
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
        user_ticket: 'آیا مطمئن هستید؟',
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
                            user_ticket: 'سطر مورد نظر با موفقیت حذف شد.',
                            position: 'bottomLeft'
                        });
                    },
                    error: function(e) {
                        console.log(e);
                        iziToast.error({
                            title: 'حذف',
                            user_ticket: 'عملیات با خطا مواجه شد.',
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
    var table = $('#user_ticket-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/