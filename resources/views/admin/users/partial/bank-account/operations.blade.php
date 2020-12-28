<a href="{{ route('admin.user_bank_accounts.edit', $user_bank_account->id) }}"
    class="btn btn-sm btn-outline-primary open-user_bank_account-modal edit"><i class="icon-edit2"></i>
    ویرایش</a>
<button data-route="{{ route('admin.user_bank_accounts.delete', $user_bank_account->id) }}"
    class="btn btn-sm btn-outline-danger delete_row"><i class="icon-delete"></i> حذف</button>
