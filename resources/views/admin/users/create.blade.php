@extends('layouts.index')
@section('styles')
    <link rel="stylesheet" href="https://rawgit.com/LeshikJanz/libraries/master/Bootstrap/baguetteBox.min.css">
    <style>
        .tz-gallery {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        img {
            max-width: 300px;
            max-height: 200px;
        }

    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">مشخصات کاربر</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collpase collapse show" style="">
                    <div class="card-body">
                        @if (isset($user))
                            {!! Form::model($user, ['route' => ['admin.users.update'], 'method' => 'POST', 'files' => true,
                            'enctype' => 'multipart/form-data', 'id' => 'frm_user']) !!}
                            {{ Form::hidden('email', $user->email) }}
                            {{ Form::hidden('id', $user->id) }}
                        @else
                            {!! Form::open(['route' => 'admin.users.store', 'method' => 'POST', 'files' => true, 'enctype'
                            => 'multipart/form-data', 'id' => 'frm_user']) !!}
                        @endif
                        <div class="m-2" style="text-align: end">
                            <button type="button" id="user-save-btn" class="btn width-100 btn-primary">
                                <i class="icon-check2"></i> ثبت
                            </button>
                            <a href="{{ route('admin.users.list') }}" class="btn width-100 btn-warning mr-1">
                                <i class="icon-cross2"></i> انصراف
                            </a>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('first_name', 'نام :') !!}
                                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('last_name', 'نام خانوادگی :') !!}
                                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('cell_phone', 'تلفن :') !!}
                                    {!! Form::text('cell_phone', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('national_code', 'کد ملی :') !!}
                                    {!! Form::text('national_code', null, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('postal_code', 'کد پستی :') !!}
                                    {!! Form::text('postal_code', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email', 'پست الکترونیک :') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('password', 'کلمه عبور :') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('address', 'آدرس :') !!}
                            {!! Form::textarea('address', null, ['class' => 'form-control', 'required', 'size' => '1x3'])
                            !!}
                        </div>

                        <ul class="nav nav-tabs nav-underline no-hover-bg">
                            <li class="nav-item">
                                <a class="nav-link active" id="document-tab" data-toggle="tab" href="#document"
                                    aria-controls="document" aria-expanded="true"><i class="fa fa-id-card"></i> اسناد</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="account-tab" data-toggle="tab" href="#account"
                                    aria-controls="account" aria-expanded="false"> <i class="fa fa-credit-card"></i> حساب
                                    بانکی</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="purchase-tab" data-toggle="tab" href="#purchase"
                                    aria-controls="purchase" aria-expanded="false"> <i class="fa fa-shopping-bag"></i> گردش
                                    حساب </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="draft-order-tab" data-toggle="tab" href="#draft-order"
                                    aria-controls="draft-order" aria-expanded="false"> <i class="fa fa-tasks"></i> سفارشات
                                    پرداخت نشده </a>
                            </li>
                        </ul>

                        <div class=" tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active" id="document" aria-labelledby="document-tab"
                                aria-expanded="true">
                                @include('admin.users.partial.user-document.detail')
                            </div>
                            <div class="tab-pane" id="account" role="tabpanel" aria-labelledby="account-tab"
                                aria-expanded="false">
                                @include('admin.users.partial.bank-account.detail')
                            </div>
                            <div class="tab-pane" id="purchase" role="tabpanel" aria-labelledby="purchase-tab"
                                aria-expanded="false">
                                @include('admin.users.partial.order.detail')

                            </div>
                            <div class="tab-pane" id="draft-order" role="tabpanel" aria-labelledby="draft-order-tab"
                                aria-expanded="false">
                                @include('admin.users.partial.draft-order.detail')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('jscontent')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
    <script src="{{ asset('js/form-js/user_bank_account.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/form-js/user_account.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/form-js/draft_order.js') }}" type="text/javascript"></script>

    <script>
        baguetteBox.run('.tz-gallery');

        function readURL(input) {
            console.log(input.files[0]);
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.' + input.id + '_image')
                        .attr('src', e.target.result);
                    $('#' + input.id + '_lable').text(input.files[0].name);
                    $('#' + input.id + '_link').prop("href", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        /***************************************** create or edit from modal ***************************************/
        $('#user-save-btn').click(function(event) {
            event.preventDefault();
            $(this).html('<i class=\'fa fa-2x fa-spinner fa-spin \' style="font-size: 12px;"></i>');
            $(this).prop("disabled", true);
            var form = $('#frm_user');
            var postData = new FormData($("#frm_user")[0]);
            var url = form.attr('action');
            var method = 'POST'; // complex way , for create and update
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
            var fileToUpload = $('#b_national')[0].files[0];
            postData.append('b_national', fileToUpload);
            fileToUpload = $('#f_national')[0].files[0];
            postData.append('f_national', fileToUpload);
            fileToUpload = $('#f_birth_certificate')[0].files[0];
            postData.append('f_birth_certificate', fileToUpload);
            fileToUpload = $('#c_birth_certificate')[0].files[0];
            postData.append('c_birth_certificate', fileToUpload);
            $.ajax({
                url: url,
                method: 'POST',
                data: postData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#user-save-btn').html('ذخیره');
                    $('#user-save-btn').prop("disabled", false);
                    window.location.href = response;
                },
                error: function(xhr) {
                    if (xhr.responseText == 'document_upload_error') {
                        iziToast.error({
                            title: 'خطا',
                            message: 'بارگذاری تعدادی از فایل ها با خطا مواجه شد.',
                            position: 'bottomLeft'
                        });
                    }
                    $('#user-save-btn').html('ذخیره');
                    $('#user-save-btn').prop("disabled", false);
                    if (xhr.responseJSON && $.isEmptyObject(xhr.responseJSON.errors) == false) {
                        var errors = xhr.responseJSON.errors;
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

    </script>

@endsection
