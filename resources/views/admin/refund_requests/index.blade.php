@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> پرسش های متداول </h4>
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
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="{{ route('admin.refund_requests.create') }}"
                                        class="btn btn-success btn-block btn-lg open-refund_request-modal create"
                                        title="کاربر - جدید"><i class="icon-edit2"></i> جدید</a></i>
                                    </a>
                                </div>
                                <div class="col-md-9"></div>
                            </div>

                            @include('admin.refund_requests.modal')

                            <table class="table table-hover mb-0 display dataTable responsive nowrap"
                                data-route="{{ route('admin.refund_requests.anyData') }}" id="refund_request-table"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>مشتری</th>
                                        <th>سبد گردان</th>
                                        <th>مبلغ</th>
                                        <th>تاریخ</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


{{--/**************************** JavaScript
*****************************/--}}
@section('jscontent')

    <script src="{{ asset('js/form-js/refund_request.js') }}" type="text/javascript"></script>

@endsection
