@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> سبد گردان - جزییات </h4>
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
                        <div class="col-xs-12 col-md-12 table-responsive">
                            @if (isset($portfolio_management))
                                {!! Form::model($portfolio_management, ['route' => ['admin.portfolio_managements.update',
                                $portfolio_management->id], 'method' => 'POST', 'files' => true, 'enctype' =>
                                'multipart/form-data', 'id' => 'frm_portfolio_management']) !!}
                                {{ Form::hidden('id', $portfolio_management->id) }}

                            @else
                                {!! Form::open(['route' => 'admin.portfolio_managements.store', 'method' => 'POST', 'files'
                                => true, 'enctype' => 'multipart/form-data', 'id' => 'frm_portfolio_management']) !!}
                            @endif
                            <div class="m-2" style="text-align: end">
                                <button type="button" id="portfolio_management-save-btn" class="btn width-100 btn-primary">
                                    <i class="icon-check2"></i> ثبت
                                </button>
                                <a href="{{ route('admin.portfolio_managements.list') }}"
                                    class="btn width-100 btn-warning mr-1">
                                    <i class="icon-cross2"></i> انصراف
                                </a>

                            </div>
                            <div class="container">
                                <div class="card-body text-center">
                                    @if (!isset($portfolio_management) || $portfolio_management->avatar == null || $portfolio_management->avatar == '')
                                        <button class="btn btn-sm btn-primary rounded-circle" id="btn-avatar" value="0"
                                            style="margin-top: 120px;margin-left: -50px;height: 30px;width: 30px;padding:0"><i
                                                class="fa fa-camera"></i></button>
                                        <input type="file" id="avatar" style="display: none;" onchange="readURL(this);">
                                        <img src="{{ asset('app-assets/images/avatar1.jpg') }}"
                                            class="rounded-circle  height-150" id="image_box"
                                            style="max-width: 150px; max-height: 150px;" alt="Card image">
                                    @elseif (isset($portfolio_management))
                                        <button class="btn btn-sm btn-primary rounded-circle" id="btn-avatar"
                                            value="{{ $portfolio_management->id }}"
                                            style="margin-top: 120px;margin-left: -50px;height: 30px;width: 30px;padding:0">
                                            <i class="fa fa-camera">
                                            </i>
                                        </button>
                                        <input type="file" id="avatar" style="display: none;" onchange="readURL(this);">
                                        <img src="{{ $portfolio_management->avatar }}" class="rounded-circle height-150"
                                            id="image_box" style="max-width: 150px; max-height: 150px;" alt="Card image">
                                    @endif

                                </div>

                                <div class="form-group">
                                    {!! Form::label('title', 'عنوان :') !!}
                                    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('describtion', 'توضیحات :') !!}
                                    {!! Form::textarea('describtion', null, ['class' => 'form-control', 'size' => '30x5'])
                                    !!}
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> تاریخچه معاملات سبد گردان </h4>
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
                        <div class="col-xs-12 col-md-12 table-responsive">
                            @include('admin.portfolio_managements.daily_trade.detail')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('jscontent')
    <script src="{{ asset('js/form-js/portfolio_daily_trade.js') }}" type="text/javascript"></script>
    <script>
        /********************************************************************************************************/
        // document.getElementById('btn-avatar').onclick = function(event) {
        $('#btn-avatar').click(function(event) {
            event.preventDefault();
            document.getElementById('avatar').click();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_box')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#portfolio_management-save-btn').click(function(event) {
            event.preventDefault();
            $(this).html('<i class=\'fa fa-2x fa-spinner fa-spin \' style="font-size: 12px;"></i>');
            $(this).prop("disabled", true);
            var form = $('#frm_portfolio_management');
            var postData = new FormData($("#frm_portfolio_management")[0]);
            var url = form.attr('action');
            var method = 'POST'; // complex way , for create and update
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
            var fileToUpload = $('#avatar')[0].files[0];
            postData.append('avatar', fileToUpload);
            $.ajax({
                url: url,
                method: 'POST',
                data: postData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    $('#portfolio_management-save-btn').html('ذخیره');
                    $('#portfolio_management-save-btn').prop("disabled", false);
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
                    $('#portfolio_management-save-btn').html('ذخیره');
                    $('#portfolio_management-save-btn').prop("disabled", false);
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

@stop
