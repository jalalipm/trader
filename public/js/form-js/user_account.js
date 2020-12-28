/********************************************* Fill DataTable user_account******************************************/
var url_user_account = $('#user_account-table').attr('data-route');

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>پست الکترونیک:</td>' +
        '<td>' + d.email + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#user_account-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url_user_account,
        columns: [{
                data: 'ref_id',
                name: 'ref_id'
            },
            {
                data: 'shamsi_transaction_date',
                name: 'shamsi_transaction_date'
            },
            {
                data: 'portfolio_management_title',
                name: 'portfolio_management_title'
            },
            {
                data: 'price',
                name: 'price',
                render: $.fn.dataTable.render.number(',', '.', 0, '')
            },
            {
                data: 'payment_type_title',
                name: 'payment_type_title'
            }
        ],
        dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
        buttons: [datatableButton],
        "language": datatableLanguage
    });
    $('#user_account-table tbody').on('click', 'td.details-control', function() {
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
    var table = $('#user_account-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/