<div class="bs-callout-blue-grey callout-border-right mt-1 p-1">
    <strong>{{ $user_ticket->title }}</strong>
    <p class="pt-1">{{ $user_ticket->comment }}</p>
</div>
<div class="container" id="div-responses" style="height: 200px;overflow-y: auto;">
    @foreach ($user_ticket_responses as $resp)
        @if ($resp->user_id != $user_ticket->user_id)
            <div class="col  d-flex justify-content-start">
                <div class="bs-callout-success callout-border-left callout-bordered callout-transparent mt-1  p-1"
                    style="width: 50%">
                    <p>{{ $resp->full_name }}
                    </p>
                    <p>{{ $resp->response }}
                    </p>
                    <p class="font-small-1 dir-ltr float-right">{{ $resp->shamsi_created_at }}
                    </p>
                </div>
            </div>
        @else
            <div class="col d-flex justify-content-end">
                <div class="bs-callout-warning callout-border-right callout-bordered callout-transparent text-right mt-1 p-1"
                    style="width: 50%">
                    <p>{{ $resp->full_name }}
                    </p>
                    <p>{{ $resp->response }}
                    </p>
                    <p class="font-small-1 dir-ltr float-left">{{ $resp->shamsi_created_at }}
                    </p>
                </div>
            </div>
        @endif
    @endforeach
</div>

{{-- @endforeach --}}
{{-- </div> --}}


{{-- {!! Form::model(['route' => ['admin.user-response-ticket.store'], 'method' => 'POST',
'id' => 'frm_support_message']) !!} --}}
{!! Form::open(['route' => 'admin.user-response-ticket.store', 'method' => 'POST', 'id' => 'frm_ticket_response']) !!}
{{ Form::hidden('ticket_id', $user_ticket->id, ['id' => 'ticket_id']) }}


<div class="container mt-1">
    <div class="row">
        <div class="float-right d-flex align-items-center" style="margin-left: 5px;">
            <button type="button" class="btn btn-info text-center" id="send_message"
                style="border-radius: 53px;width: 45px;height: 45px;padding-top: 10px;">
                <i class="fa fa-send" style="font-size: 20px;"></i>
            </button>
        </div>
        <div class="float-right" style="width: 90%;">
            <textarea type="text" class="form-control" oninput="auto_grow(this)"
                style="border-radius: 25px;overflow:hidden;resize:none;padding: 10px 30px 10px 30px;min-height: 50px;max-height: 100px;"
                id="response" name="response" placeholder="پیام خود را وارد کنید"></textarea>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>

<script>
    function scroll_move_to_end() {
        $('#div-responses').animate({
            scrollTop: $(document).height()
        }, 100);
    }
    //--------scroll to end div-------------------
    $(document).ready(function() {
        scroll_move_to_end();
    });

    $('textarea#response').keydown(function(e) {
        if (e.keyCode === 13 && e.ctrlKey) {
            $(this).val(function(i, val) {
                return val + "\n";
            });
        }
    }).keypress(function(e) {
        if (e.keyCode === 13 && !e.ctrlKey) {
            send_message();
            return false;
        }
    });

    $('#send_message').click(function() {
        send_message();
    });

</script>
