<a href="{{ route('admin.messages.edit', $message->id) }}"
    class="btn btn-sm btn-outline-primary open-message-modal edit"><i class="icon-edit2"></i> ویرایش</a>
<button data-route="{{ route('admin.messages.delete', $message->id) }}"
    class="btn btn-sm btn-outline-danger delete_row"><i class="icon-delete"></i> حذف
</button>
