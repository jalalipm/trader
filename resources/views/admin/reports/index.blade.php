@extends('layouts.index')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/checkboxes-radios.css') }}">
@stop
@section('content')

    {{-- @if ($kind != 2 && $kind != 3 && $kind != 18)
        --}}
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">فیلتر</h4>
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
                                {{-- @if ($kind == 1)
                                    --}}
                                    @include('admin.reports.cost_benefit.filter')
                                    {{-- @endif
                                --}}
                                <div class="form-group float-right">
                                    <button type="button" class="btn btn-outline-success btn-lg"
                                        id="btn-refresh">بازیابی</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--
    @endif --}}
    <div class="row mt-1">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $report_title }}</h4>
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
                        <div class="col-xs-12 col-md-12 table-responsive" id="report-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jscontent')
    <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.js') }}" type="text/javascript"></script>
    <script>
        $('.shamsi').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD',
            initialValue: false,
            altField: '.observer-example-alt',
            autoClose: true
        });
        $('#btn-refresh').click(function(event) {
            event.preventDefault();
            var form = $('#cost-benefit-report');
            var url = form.attr('action');
            // alert(url);
            //reset error message
            form.find('.help-block').remove();
            form.find('.form-group').removeClass('has-error');
            $.ajax({
                url: url,
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#report-body').html(response);
                },
                error: function(xhr) {

                }
            });
        });

    </script>
@endsection
