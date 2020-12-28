/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Wizard tabs with numbers setup
$(".number-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Vertical tabs form wizard setup
$(".vertical-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Validate steps wizard

// Show form
var form = $(".steps-validation").show();

$(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'ذخیره',
        previous: 'قبلی',
        next: 'بعدی'
    },
    onStepChanging: function(event, currentIndex, newIndex) {
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {
            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        if (newIndex === 3 && Number($("#age-2").val()) < 18) {
            return false;
        }
        // Needed in some cases if the user went back (clean up)
        if (currentIndex < newIndex) {
            // To remove error styles
            form.find(".body:eq(" + newIndex + ") label.error").remove();
            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
        }
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function(event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function(event, currentIndex) {
        // alert("Submitted1!");
        let form = $('.accommodation-form form');
        var url = form.attr('action');
        var method = $('.accommodation-form input[name=_method]').val() == undefined ? 'POST' : 'PUT'; // complex way , for create and update
        // alert(method);
        // alert(url);
        CKupdate();
        console.log(form.serialize());
        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            success: function(response) {
                if (method == 'POST') {
                    //alert('ok');
                    // $('#good-modal').modal('hide');
                    iziToast.success({
                        title: 'ایجاد',
                        message: 'ویلا جدید با موفقیت ایجاد شد.',
                        position: 'bottomLeft'
                    });
                    $(location).attr('href', response);

                } else {
                    //alert('nok');
                    // $('#good-modal').modal('hide');
                    iziToast.success({
                        title: 'ویرایش',
                        message: 'اطلاعات با موفقیت ویرایش شد.',
                        position: 'bottomLeft'
                    });
                    $(location).attr('href', response);

                }
                reloadTable();
            },
            error: function(xhr) {
                // console.log(xhr);
                if (xhr.responseText == 'keyword-duplicate') {
                    iziToast.error({
                        title: 'خطا',
                        message: 'کلمه کلیدی مورد نظر تکراری می باشد.',
                        position: 'bottomLeft'
                    });
                }
                var errors = xhr.responseJSON.errors;
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

    }
});

function CKupdate() {
    for (var instance in CKEDITOR.instances)
        CKEDITOR.instances[instance].updateElement();
}

// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    rules: {
        email: {
            email: true
        }
    }
});


// Initialize plugins
// ------------------------------

// Date & Time Range
// $('.datetime').daterangepicker({
//     timePicker: true,
//     timePickerIncrement: 30,
//     locale: {
//         format: 'MM/DD/YYYY h:mm A'
//     }
// });