<a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary"><i class="icon-edit2"></i>
    ویرایش</a>
<button data-route="{{ route('admin.users.delete', $user->id) }}" class="btn btn-sm btn-outline-danger delete_row"><i
        class="icon-delete"></i> حذف</button>
{{--<a href="{{ route('admin.addresses.list', $user->id) }}"
    class="btn btn-sm btn-outline-warning open-address-user-modal"><i class="icon-list"></i>
    آدرس</a>--}}
