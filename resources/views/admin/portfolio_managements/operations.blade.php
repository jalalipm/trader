<a href="{{ route('admin.portfolio_managements.edit', $portfolio_management->id) }}" {{--
    class="btn btn-sm btn-outline-primary open-portfolio_management-modal edit"><i class="icon-edit2"></i> ویرایش</a>
--}}
class="btn btn-sm btn-outline-primary "><i class="icon-edit2"></i> ویرایش</a>
{{-- <a
    href="{{ route('admin.portfolio_managements.delete', $portfolio_management->id) }}"
    class="btn btn-sm btn-outline-danger delete_row"><i class="icon-delete"></i> حذف</a>
--}}
<button data-route="{{ route('admin.portfolio_managements.delete', $portfolio_management->id) }}"
    class="btn btn-sm btn-outline-danger delete_row"><i class="icon-delete"></i> حذف</button>
