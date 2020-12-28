/********************************************* Fill DataTable draft_order******************************************/
var url_draft_order = $('#draft_order-table').attr('data-route');

$(function() {
    var table = $('#draft_order-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url_draft_order,
        columns: [{
                data: 'portfolio_management_title',
                name: 'portfolio_management_title'
            },
            {
                data: 'price',
                name: 'price',
                render: $.fn.dataTable.render.number(',', '.', 0, '')
            },
            {
                data: 'tracking_code',
                name: 'tracking_code'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // }
        ],
        dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
        buttons: [datatableButton],
        "language": datatableLanguage
    });
    $('#draft_order-table tbody').on('click', 'td.details-control', function() {
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

/****************************************** Reload DataTable **********************************************/

function reloadTable() {
    var table = $('#draft_order-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/

$('body').on('click', '.convert', function(event) {
    event.preventDefault();
    let me = $(this);
    let url = me.attr('data-route');
    let draft_data = me.attr('draft-data');
    let ref_id = me.attr('ref-data');
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
                        draft_order_id: draft_data,
                        ref_id: ref_id,
                        _token: mToken
                    },
                    success: function(resp) {
                        iziToast.success({
                            title: 'حذف',
                            message: 'سفارش مورد نظر با موفقیت تبدیل شد.',
                            position: 'bottomLeft'
                        });
                    },
                    error: function(e) {
                        console.log(e);
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