@extends('layouts.index')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-callout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/ui/prism.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">پشتیبانی</h4>
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

                            @include('admin.user_tickets.modal')

                            <table class="table table-hover mb-0 display dataTable responsive"
                                data-route="{{ route('admin.user_tickets.anyData') }}" id="user_ticket-table" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>مشتری</th>
                                        <th>عنوان</th>
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
    <script src="{{ asset('js/form-js/user_ticket.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/ui/prism.min.js') }}" type="text/javascript"></script>
    <script>
        function auto_grow(element) {
            element.style.height = "5px";
            element.style.height = (element.scrollHeight) + "px";
        }


        function send_message() {
            var ticket_id = $('#ticket_id').val();
            var response = $('#response').val();
            var url = $('#frm_ticket_response').attr('action');
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: mToken,
                    ticket_id: ticket_id,
                    response: response
                },
                success: function(resp) {
                    var now = new Date(Date.now());
                    var comment_time = now.getHours() + ":" + now.getMinutes();
                    $('#div-responses').append('<div class="col d-flex justify-content-start">' +
                        '<div class="bs-callout-success callout-border-left' +
                        ' callout-bordered callout-transparent mt-1  p-1" style="width: 50%"> <p>' +
                        resp.response.full_name + '</p>' +
                        '<p>' + resp.response.response + '</p>' +
                        '<p class="font-small-1 dir-ltr float-right">' + resp.response.shamsi_created_at +
                        '</p> </div> </div>'
                    );
                    $('#response').val('');
                    $("#response").focus();
                    scroll_move_to_end();
                },
                error: function(xhr) {

                }
            });
        }

    </script>
@endsection
