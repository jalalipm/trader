/********************************************* Open Modal Address **************************************************/
let mToken = $('meta[name="csrf-token"]').attr('content');
/********************************************* Open Modal Add/Edit **************************************************/
$('body').on('click', '.open-portfolio_daily_trade-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    // alert(url);
    $('#portfolio_daily_trade-modal-title').html("جزییات - کاربر");
    $('#portfolio_daily_trade-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    //alert(me.hasClass('edit'));
    //alert(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#portfolio_daily_trade-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#portfolio_daily_trade-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#portfolio_daily_trade-save-btn').click(function(event) {
    event.preventDefault();

    let form = $('#portfolio_daily_trade-modal-body form');
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
                $('#portfolio_daily_trade-modal').modal('hide');
                iziToast.success({
                    title: 'ایجاد',
                    message: 'حساب جدید با موفقیت ایجاد شد.',
                    position: 'bottomLeft'
                });
            } else {
                $('#portfolio_daily_trade-modal').modal('hide');
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
/********************************************* Fill DataTable portfolio_daily_trade******************************************/
let url = $('#portfolio_daily_trade-table').attr('data-route');

function separator(d) {
    let num = d.substr(0, d.indexOf('.'));
    if (num.length > 3)
        num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    return num;
}

$(function() {
    var table = $('#portfolio_daily_trade-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [{
                data: 'shamsi_trade_date',
                name: 'shamsi_trade_date'
            },
            {
                data: 'trade_nav',
                name: 'trade_nav',
                render: $.fn.dataTable.render.number(',', '.', 0, '')
            },
            {
                data: 'trade_percent',
                name: 'trade_percent'
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
    var table = $('#portfolio_daily_trade-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/