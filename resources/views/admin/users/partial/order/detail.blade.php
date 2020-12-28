<table class="table table-hover mb-0 display dataTable responsive nowrap"
    data-route="{{ route('admin.user_accounts.anyData', isset($user) ? $user->id : 0) }}" id="user_account-table"
    width="100%">
    <thead>
        <tr>
            {{-- <th></th> --}}
            <th>کد رهگیری</th>
            <th>زمان تراکنش</th>
            <th>سبد گردان</th>
            <th>مبلغ</th>
            <th>بابت</th>
        </tr>
    </thead>
</table>
