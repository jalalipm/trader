/********************************************* Open Modal Address **************************************************/
let mToken = $('meta[name="csrf-token"]').attr('content');
/********************************************* Open Modal Add/Edit **************************************************/
$('body').on('click', '.open-faq-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    // alert(url);
    $('#faq-modal-title').html("جزییات - کاربر");
    $('#faq-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    //alert(me.hasClass('edit'));
    //alert(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#faq-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#faq-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#faq-save-btn').click(function(event) {
    event.preventDefault();

    let form = $('#faq-modal-body form');
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
                $('#faq-modal').modal('hide');
                iziToast.success({
                    title: 'ایجاد',
                    message: 'پرسش جدید با موفقیت ایجاد شد.',
                    position: 'bottomLeft'
                });
            } else {
                $('#faq-modal').modal('hide');
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
/********************************************* Fill DataTable faq******************************************/
let url = $('#faq-table').attr('data-route');

function separator(d) {
    let num = d.substr(0, d.indexOf('.'));
    if (num.length > 3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    return num;
}

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td> پاسخ :</td>' +
        '<td style="white-space: initial;">' + d.answer + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#faq-table').DataTable({
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
                data: 'code',
                name: 'code'
            },
            {
                data: 'question',
                name: 'question'
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
    $('#faq-table tbody').on('click', 'td.details-control', function() {
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
    var url = me.attr('data-route');
    iziToast.show({
        theme: 'dark',
        icon: 'icon-person',
        title: 'حذف',
        message: 'آیا مطمئن هستید؟',
        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
            ['<button>بله</button>', function(instance, toast) {
                alert(url);
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
    var table = $('#faq-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/