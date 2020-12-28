/********************************************* Fill DataTable payment******************************************/
var url_payment = $('#payment-table').attr('data-route');

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td> پرداخت کننده : </td>' +
        '<td>' + d.payer_name + '</td>' +
        '</tr>' +
        '<tr>' +
        '<td> شماره کارت : </td>' +
        '<td>' + d.payer_card + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#payment-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url_payment,
        columns: [{
                "className": 'details-control',
                orderable: false,
                "data": null,
                "defaultContent": '',
                searchable: false
            },
            {
                data: 'full_name',
                name: 'full_name'
            },
            {
                data: 'ref_id',
                name: 'ref_id'
            },
            {
                data: 'shamsi_transaction_date',
                name: 'shamsi_transaction_date'
            },
            {
                data: 'amount',
                name: 'amount',
                render: $.fn.dataTable.render.number(',', '.', 0, '')
            },
            {
                data: 'reference_number',
                name: 'reference_number'
            },
            // {
            //     data: 'status_title',
            //     name: 'status_title'
            // }
            {
                data: "status_title",
                "render": function(data, type, row) {
                    return /*(data == 'موفق') ?*/ '<div class="badge badge-success round"><i class = "fa fa-check font-medium-2"></i><span> موفق </span></div>'
                        /*: '<i class = "fa fa-square-o font-medium-4"></i>'*/
                }
            },
        ],
        dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
        buttons: [datatableButton],
        "language": datatableLanguage
    });
    $('#payment-table tbody').on('click', 'td.details-control', function() {
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
    var table = $('#payment-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/