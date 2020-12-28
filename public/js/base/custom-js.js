function addSeparators(nStr, isDecimal) {
    var num = 0;
    var dec = 0;
    if (isDecimal == 1) {
        // console.log(1);
        if (nStr.value.indexOf('.') < 0) {
            num = nStr.value.replace(/[^\d]/g, '');
        } else {
            num = nStr.value.substr(0, nStr.value.indexOf('.'));
            dec = nStr.value.substr(nStr.value.indexOf('.'));
        }
        if (num.length > 3)
            num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
        if (dec.length > 0)
            num = num + dec;

    } else {
        if (nStr.value.indexOf('.') < 0) {
            num = nStr.value.replace(/[^\d]/g, '');
        } else {
            num = nStr.value.substr(0, nStr.value.indexOf('.'));
        }
        if (num.length > 3)
            num = num.replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
    }
    // var num = nStr.value;
    // console.log(num);
    // var num = nStr.value.replace(/[^\d]/g, '');

    nStr.value = num;
}

$(".has-separator").keyup(function() {
    addSeparators(this);
});
// $(".has-separator").paste(function () {
//     addSeparators(this);
// });
$(".has-separator").each(function() {
    // alert(this.value.substr(0,d.indexOf('.')));
    addSeparators(this);
});

$(".has-separator-d").each(function() {
    // alert(this.value.substr(0,d.indexOf('.')));
    addSeparators(this, 1);
});
$(".has-separator-d").keyup(function() {
    addSeparators(this, 1);
});

//--------------------------------SendToAll in Index-layout--------------------------------
function isEmpty(el) {
    return $.trim(el.val()) == ''
}

$("#message-dropdown").click(function() {
    var form = $('#usermessage-body form');
    form.find('.help-block').remove();
    form.find('.form-group').removeClass('has-danger');
    $("#send-message").val('');
});

$('#usermessage-btn').click(function(event) {
    event.preventDefault();
    if (isEmpty($('#send-message'))) {
        $('#send-message')
            .closest('.form-group')
            .addClass('has-danger')
            .append('<span class="danger help-block">پیام خالی است </span>');
    }
    var form = $('#usermessage-body form');
    var url = form.attr('action');
    var method = 'POST'; // complex way , for create and update
    $.ajax({
        url: url,
        method: method,
        data: form.serialize(),
        success: function(response) {
            iziToast.success({
                title: 'ارسال',
                message: 'پیام کلی با موفقیت ارسال شد.',
                position: 'bottomLeft'
            });
        },
        error: function(xhr) {
            if (!isEmpty($('#send-message'))) {
                iziToast.error({
                    title: 'خطا',
                    message: 'ارسال با خطا مواجه شد',
                    position: 'bottomLeft'
                });
            }
        }
    });
});
//------------------------------------Select2 Config--------------------------------------
var $placeholder = 'انتخاب کنید ...';

$('.select2, .single-select').select2({
    language: "fa",
    dir: "rtl",
    placeholder: $placeholder,
    allowClear: true,
    //minimumInputLength: 2,
    //multiple: true
});

$('.multiple-select').select2({
    language: "fa",
    dir: "rtl",
    placeholder: $placeholder,
    allowClear: false,
    //minimumInputLength: 2,
    multiple: true,
});

$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        dir: "rtl"
    });
});
//---------------------------------SidBar Active----------------------------------------
$(document).ready(function() {
    // alert($(location).attr("href"));
    var pathname = $(location).attr("href");
    $('a[href="' + pathname + '"]').parent().addClass('active');
});

//-------------------------------Ring New Order -----------------------------------------
function playSound() {
    ion.sound({
        sounds: [{
                name: "beer_can_opening"
            },
            {
                name: "bell_ring"
            },
            {
                name: "branch_break"
            },
            {
                name: "button_click"
            }
        ],

        // main config
        path: '{{url("")}}/alert/',
        preload: true,
        multiplay: true,
        volume: 0.9
    });
    ion.sound.play("bell_ring");
}

function incTimer() {
    $(function() {
        let url = '{{ route("admin.orderheaders.lastinvoice") }}';
        $.ajax({
            url: url,
            method: 'get',
            success: function(data) {
                if (last_invoice != data['max_id']) {
                    if (last_invoice != 0) {
                        // alert(totalSecs);
                        playSound();
                    }
                    last_invoice = data['max_id'];
                }
                if (totalSecs == 6 && data['count_on_process'] > 0) {
                    playSound();
                    totalSecs = 0;
                }
            }
        });
    });


    totalSecs++;
    setTimeout('incTimer()', 5000);
    // setTimeout('incTimer(0)', 30000);
}

totalSecs = 0;
last_invoice = 0;
$(document).ready(function() {
    //$("#start").click(function() {
    //incTimer();
    //});
    //playSound();
});

function CKupdate() {
    for (var instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}


var datatableButton = [{
        extend: "copy",
        text: "کپی",
        className: "btn btn-sm btn-info btn-lg",
        init: function(api, node, config) {
            $(node).removeClass('btn-default dt-button')
        }
    },
    {
        extend: "excel",
        text: "اکسل",
        className: "btn btn-sm btn-success btn-lg",
        init: function(api, node, config) {
            $(node).removeClass('btn-default dt-button')
        }
    }, {
        extend: "print",
        text: "چاپ",
        className: "btn btn-sm btn-warning btn-lg",
        init: function(api, node, config) {
            $(node).removeClass('btn-default dt-button')
        }
    }, {
        extend: "colvis",
        text: "ستون ها",
        className: "btn btn-sm btn-primary btn-lg",
        init: function(api, node, config) {
            $(node).removeClass('btn-default dt-button')
        }
    }
];

var datatableLanguage = {
    "sEmptyTable": "هیچ داده ای در جدول وجود ندارد",
    "sInfo": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
    "sInfoEmpty": "نمایش 0 تا 0 از 0 رکورد",
    "sInfoFiltered": "(فیلتر شده از _MAX_ رکورد)",
    "sInfotagFix": "",
    "sInfoThousands": ",",
    "sLengthMenu": "نمایش _MENU_ رکورد",
    "sLoadingRecords": "در حال بارگزاری...",
    "sProcessing": "در حال پردازش...",
    "sSearch": "جستجو:",
    "sZeroRecords": "رکوردی با این مشخصات پیدا نشد",
    "oPaginate": {
        "sFirst": "ابتدا",
        "sLast": "انتها",
        "sNext": "بعدی",
        "sPrevious": "قبلی"
    },
    "oAria": {
        "sSortAscending": ": فعال سازی نمایش به صورت صعودی",
        "sSortDescending": ": فعال سازی نمایش به صورت نزولی"
    }
};