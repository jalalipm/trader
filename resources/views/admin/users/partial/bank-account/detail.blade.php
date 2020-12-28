@if (isset($user))
    <div class="row">
        <div class="col-md-2">
            <a href="{{ route('admin.user_bank_accounts.create', $user->id) }}"
                class="btn btn-success btn-block btn-lg open-user_bank_account-modal create" title="کاربر - جدید"><i
                    class="icon-edit2"></i> جدید</a></i>
            </a>
        </div>
        <div class="col-md-9"></div>
    </div>
@endif
@include('admin.users.partial.bank-account.modal')

<table class="table table-hover mb-0 display dataTable responsive nowrap"
    data-route="{{ route('admin.user_bank_accounts.anyData', isset($user) ? $user->id : 0) }}"
    id="user_bank_account-table" width="100%">
    <thead>
        <tr>
            <th>نام صاحب حساب</th>
            <th>شماره کارت</th>
            <th>بانک</th>
            <th>شبا</th>
            <th>عملیات</th>
        </tr>
    </thead>
</table>
