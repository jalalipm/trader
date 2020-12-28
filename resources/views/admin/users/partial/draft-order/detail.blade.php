<table class="table table-hover mb-0 display dataTable responsive nowrap"
    data-route="{{ route('admin.draft_orders.anyData', isset($user) ? $user->id : 0) }}" id="draft_order-table"
    width="100%">
    <thead>
        <tr>
            <th>سبد گردان</th>
            <th>مبلغ</th>
            <th>کد رهگیری</th>
            {{-- <th>عملیات</th> --}}
        </tr>
    </thead>
</table>
