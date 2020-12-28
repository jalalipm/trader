@if (isset($message))
    {!! Form::model($message, ['route' => ['admin.messages.update', $message->id], 'method' => 'POST']) !!}
    {{ Form::hidden('id', $message->id) }}

@else
    {!! Form::open(['route' => 'admin.messages.store', 'method' => 'POST']) !!}
@endif
<div class="form-group">
    {!! Form::label('user_id', 'مشتری :') !!}
    {!! Form::select('user_id', $customers, isset($message) ? $message->user_id : null, [
    'class' => 'form-control
    select2 single-select',
    'required',
    'placeholder' => 'لطفا انتخاب کنید...',
    'style' => 'width: 100%;',
    ]) !!}
</div>

<div class="form-group">
    {!! Form::label('title', 'عنوان :') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('message', 'پیام :') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control', 'required', 'size' => '30x3']) !!}
</div>


{!! Form::close() !!}
<script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>
