@if (isset($faq))
    {!! Form::model($faq, ['route' => ['admin.faqs.update', $faq->id], 'method' => 'POST', 'id' => 'detail_modal_faq'])
    !!}
    {{ Form::hidden('id', $faq->id) }}

@else
    {!! Form::open(['route' => 'admin.faqs.store', 'method' => 'POST', 'id' => 'detail_modal_faq']) !!}
@endif

<div class="form-group">
    {!! Form::label('code', 'کد :') !!}
    {!! Form::text('code', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('question', 'سوال :') !!}
    {!! Form::textarea('question', null, ['class' => 'form-control', 'required', 'size' => '30x3']) !!}
</div>

<div class="form-group">
    {!! Form::label('answer', 'پاسخ :') !!}
    {!! Form::textarea('answer', null, ['class' => 'form-control', 'size' => '30x5']) !!}
</div>

{!! Form::close() !!}
