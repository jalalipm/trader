{{-- {{ dd($center_id, $store_id, $good_id, $s_date, $e_date) }}
--}}

<table class="table table-hover mb-0 display dataTable responsive nowrap"
    data-route="{{ route('admin.reports.cost-benefit-report-any-data', $condition) }}" id="cost_benefit-table"
    width="100%">
    <thead>
        <tr>
            <th>تاریخ</th>
            <th>سرمایه</th>
            <th>سرمایه فعلی</th>
            <th>سودوزیان</th>
            <th>کارمزد</th>
            <th>مانده پس از کارمزد</th>
            <th>واریز</th>
            <th>برداشت</th>
            {{-- <th>قابل برداشت</th> --}}
            <th>مبلغ کل</th>
            {{-- <th>درصد از سبد</th> --}}
            <th>خالص</th>
        </tr>
    </thead>
</table>


<script>
    /********************************************* Fill DataTable center_cost******************************************/
    var url = $('#cost_benefit-table').attr('data-route');

    $(function() {
        var table = $('#cost_benefit-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [{
                    data: 'shamsi_trade_date',
                    name: 'shamsi_trade_date'
                },
                {
                    data: 'fund',
                    name: 'fund',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'current_fund',
                    name: 'current_fund',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'cost_benefit',
                    name: 'cost_benefit',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'basket_commission',
                    name: 'basket_commission',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'remain_after_commission',
                    name: 'remain_after_commission',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'deposit',
                    name: 'deposit',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'withdraw',
                    name: 'withdraw',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                // {
                //     data: 'withdrawable',
                //     name: 'withdrawable',
                //     render: $.fn.dataTable.render.number(',', '.', 0, '')
                // },
                {
                    data: 'pure_price',
                    name: 'pure_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                // {
                //     data: 'percent_of_basket',
                //     name: 'percent_of_basket',
                //     render: $.fn.dataTable.render.number(',', '.', 3, '')
                // },
                {
                    data: 'final_price',
                    name: 'final_price',
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                }
            ],
            dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
            buttons: [{
                    extend: "copy",
                    text: "کپی",
                    className: "btn btn-sm btn-info btn-lg",
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default dt-button')
                    }
                },
                {
                    extend: "excel",
                    text: "اکسل",
                    className: "btn btn-sm btn-success btn-lg",
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default dt-button')
                    }
                },
                {
                    extend: "print",
                    text: "چاپ",
                    className: "btn btn-sm btn-warning btn-lg",
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default dt-button')
                    }
                },
                {
                    extend: "colvis",
                    text: "ستون ها",
                    className: "btn btn-sm btn-primary btn-lg",
                    init: function(api, node, config) {
                        $(node).removeClass('btn-default dt-button')
                    }
                },
            ],
            "language": {
                "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
                "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                "sInfoEmpty": "نمایش 0 تا 0 از 0 رکورد",
                "sInfoFiltered": "(فیلتر شده از _MAX_ رکورد)",
                "sInfotagFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "نمایش _MENU_ رکورد",
                "sLoadingRecords": "در حال بارگزاری...",
                "sProcessing": "در حال پردازش...",
                "sSearch": "جستجو:",
                "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
                "oPaginate": {
                    "sFirst": "ابتدا",
                    "sLast": "انتها",
                    "sNext": "بعدی",
                    "sPrevious": "قبلی"
                },
                "oAria": {
                    "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
                    "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
                }
            },
        });
    });

</script>
