@if (isset($portfolio_management))
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('admin.portfolio_daily_trades.create', $portfolio_management->id) }}"
                class="btn btn-success btn-block btn-lg  open-portfolio_daily_trade-modal create"
                title=" کاربر - جدید"><i class="icon-edit2"></i> جدید</a></i>
            </a>
        </div>
        <div class="col-md-9"></div>
    </div>
@endif

@include('admin.portfolio_managements.daily_trade.modal')


<table class="table table-hover mb-0 display dataTable responsive nowrap"
    data-route="{{ route('admin.portfolio_daily_trades.anyData', isset($portfolio_management) ? $portfolio_management->id : 0) }}"
    id="portfolio_daily_trade-table" width="100%">
    <thead>
        <tr>
            <th>تاریخ</th>
            <th>Nav</th>
            <th>درصد سود و زیان</th>
            <th>عملیات</th>
        </tr>
    </thead>
</table>
