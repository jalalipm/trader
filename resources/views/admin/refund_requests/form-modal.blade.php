@if (isset($refund_request))
    {!! Form::model($refund_request, ['route' => ['admin.refund_requests.update', $refund_request->id], 'method' =>
    'POST', 'id' => 'detail_modal_refund_request']) !!}
    {{ Form::hidden('id', $refund_request->id) }}

@else
    {!! Form::open(['route' => 'admin.refund_requests.store', 'method' => 'POST', 'id' =>
    'detail_modal_refund_request']) !!}
@endif

<div class="form-group">
    {!! Form::label('portfolio_management_id', 'سبد گردان :') !!}
    {{-- {!! Form::select('portfolio_management_id', $portfolio_managements, null,
    ['class' => 'form-control select', 'required']) !!} --}}
    {!! Form::select('portfolio_management_id', $portfolio_managements, isset($refund_request) ?
    $refund_request->portfolio_management_id : null, [
    'class' => 'form-control
    select2 single-select',
    'required',
    'placeholder' => 'لطفا انتخاب کنید...',
    'style' => 'width: 100%;',
    ]) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('price', 'مبلغ :') !!}
            {!! Form::text('price', null, ['class' => 'form-control has-separator', 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('status', 'وضعیت :') !!}
            {{-- {!! Form::select('status', $statuses, null, [
            'class' => 'form-control
            select',
            'required',
            ]) !!} --}}
            {!! Form::select('status', $statuses, isset($refund_request) ? $refund_request->status : null, [
            'class' => 'form-control
            select2 single-select',
            'required',
            'placeholder' => 'لطفا انتخاب کنید...',
            'style' => 'width: 100%;',
            ]) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('comment', 'توضیحات :') !!}
    {!! Form::textarea('comment', null, ['class' => 'form-control', 'size' => '30x5']) !!}
</div>
{!! Form::close() !!}

<script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>
