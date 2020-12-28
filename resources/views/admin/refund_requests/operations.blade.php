<a href="{{ route('admin.refund_requests.edit', $refund_request->id) }}"
    class="btn btn-sm btn-outline-primary open-refund_request-modal edit"><i class="icon-edit2"></i> ویرایش</a>
<button data-route="{{ route('admin.refund_requests.delete', $refund_request->id) }}"
    class="btn btn-sm btn-outline-danger delete_row"><i class="icon-delete"></i> حذف</button>
