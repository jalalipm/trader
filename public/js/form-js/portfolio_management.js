let mToken = $('meta[name="csrf-token"]').attr('content');
/********************************************* Open Modal **************************************************/
$('body').on('click', '.open-portfolio_management-modal', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('href');
    var title = me.attr('title');
    $('#portfolio_management-save-btn').text(me.hasClass('edit') ? 'ویرایش' : 'ایجاد');
    //alert(me.hasClass('edit'));
    //alert(url);
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
            //alert(ddd);
            $('#portfolio_management-modal-body').html(response);
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });
    $('#portfolio_management-modal').modal('show');
});
/***************************************** create or edit from modal ***************************************/
$('#portfolio_management-save-btn').click(function(event) {
    event.preventDefault();

    var form = $('#portfolio_management-modal-body form');
    // var formData = new FormData(form);
    var postData = new FormData($("#detail_modal_portfolio_management")[0]);
    var url = form.attr('action');
    var method = $('#portfolio_management-modal-body input[name=_method]').val() == undefined ? 'POST' : 'PUT'; // complex way , for create and update
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-error');
    var fileToUpload = $('#avatar')[0].files[0];
    postData.append('avatar', fileToUpload);
    // console.log(fileToUpload);
    $.ajax({
        url: url,
        method: 'POST',
        //data: form.serialize(),
        data: postData,
        cache: false,
        processData: false,
        contentType: false,

        success: function(data) {
            if (method == 'POST') {
                // alert('ok');
                // console.log(data = 'new');
                var message = '';
                var title = '';
                if (data == 'new') {
                    message = 'سبدگردان جدید با موفقیت ایجاد شد.';
                    title = 'ایجاد';
                } else {
                    message = 'اطلاعات با موفقیت ویرایش شد.';
                    title = 'ویرایش';
                }
                $('#portfolio_management-modal').modal('hide');
                iziToast.success({
                    title: title,
                    message: message,
                    position: 'bottomLeft'
                });
            } else {
                //alert('nok');
                $('#portfolio_management-modal').modal('hide');
                iziToast.success({
                    title: 'ویرایش',
                    message: 'اطلاعات با موفقیت ویرایش شد.',
                    position: 'bottomLeft'
                });
            }
            reloadTable();
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            //console.log(xhr);
            if ($.isEmptyObject(errors) == false) {
                $.each(errors, function(key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-danger')
                        .append('<span class="danger help-block">' + value + '</span>');
                });
            }
        }
    });
});
/********************************************* Fill DataTable **********************************************/
var url = $('#portfolio_management-table').attr('data-route');

function format(d) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td> توضیحات :</td>' +
        '<td style="white-space: initial;">' + d.describtion + '</td>' +
        '</tr>' +
        '</table>';
}
$(function() {
    var table = $('#portfolio_management-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [{
                "className": 'details-control',
                orderable: false,
                "data": null,
                "defaultContent": '',
                searchable: false
            },
            {
                data: 'avatar',
                name: 'avatar',
                "render": function(data, type, full, meta) {
                    return "<img src=\"" + data + "\" class=\"rounded-circle\" height=\"60\" width=\"60\"/>";
                }
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        dom: '<"top"<"row" <"col-lg-6 col-sx-12" B> <"col-lg-6 col-sx-12" f > ><"row" <"col-sm-6" l> <"col-sm-6" p> >>rt<"bottom"<"row" <"col-sm-6" i> <"col-sm-6" p> >><"clear">',
        buttons: [datatableButton],
        "language": datatableLanguage
    });
    $('#portfolio_management-table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});
/******************************************** Delete Row **************************************************/
$('body').on('click', '.delete_row', function(event) {
    event.preventDefault();
    var me = $(this);
    var url = me.attr('data-route');
    //alert(url);
    iziToast.show({
        theme: 'dark',
        icon: 'icon-person',
        title: 'حذف',
        message: 'آیا مطمئن هستید؟',
        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        progressBarColor: 'rgb(0, 255, 184)',
        buttons: [
            ['<button>بله</button>', function(instance, toast) {
                // alert(url);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'delete',
                        _token: mToken
                    },
                    success: function(resp) {
                        iziToast.success({
                            title: 'حذف',
                            message: 'سطر مورد نظر با موفقیت حذف شد.',
                            position: 'bottomLeft'
                        });
                    },
                    error: function(e) {
                        // alert(e);
                        iziToast.error({
                            title: 'حذف',
                            message: 'عملیات با خطا مواجه شد.',
                            position: 'bottomLeft'
                        });
                    }
                });
                reloadTable();
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy) {
                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                    }
                }, toast, 'buttonName');
            }, true], // true to focus
            ['<button>خیر</button>', function(instance, toast) {
                instance.hide({
                    transitionOut: 'fadeOutUp',
                    onClosing: function(instance, toast, closedBy) {
                        console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                    }
                }, toast, 'buttonName');
            }]
        ],
        onOpening: function(instance, toast) {
            console.info('callback abriu!');
        },
        onClosing: function(instance, toast, closedBy) {
            console.info('closedBy: ' + closedBy); // tells if it was closed by 'drag' or 'button'
        }
    });
});
/****************************************** Reload DataTable **********************************************/
function reloadTable() {
    var table = $('#portfolio_management-table').dataTable();
    table.fnStandingRedraw();
}
/********************************************************************************************************/
// function readURL(input) {
//     alert(0);
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function(e) {
//             $('#image_box')
//                 .attr('src', e.target.result)
//                 .width(150)
//                 .height(150);
//         };
//         reader.readAsDataURL(input.files[0]);
//     }
// }

// $(function() {

//     document.getElementById('btn-avatar').onclick = function() {
//         document.getElementById('avatar').click();
//     };
//     // We can attach the `fileselect` event to all file inputs on the page
//     $(document).on('change', ':file', function() {
//         var input = $(this),
//             numFiles = input.get(0).files ? input.get(0).files.length : 1,
//             label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
//         input.trigger('fileselect', [numFiles, label]);
//     });
//     // We can watch for our custom `fileselect` event like this
//     $(document).ready(function() {
//         $(':file').on('fileselect', function(event, numFiles, label) {
//             var input = $(this).parents('.input-group').find(':text'),
//                 log = numFiles > 1 ? numFiles + ' files selected' : label;
//             // console.log(input);
//             if (input.length) {
//                 input.val(log);
//             } else {
//                 // if (log) alert(log);
//             }
//         });
//     });
// });