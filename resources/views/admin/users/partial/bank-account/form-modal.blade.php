@if (isset($user_bank_account))
    {!! Form::model($user_bank_account, ['route' => ['admin.user_bank_accounts.update'], 'method' => 'POST']) !!}
    {{ Form::hidden('id', $user_bank_account->id) }}
@else
    {!! Form::open(['route' => 'admin.user_bank_accounts.store', 'method' => 'POST']) !!}
@endif
{{ Form::hidden('user_id', $user_id) }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('account_holder', 'نام صاحب حساب :') !!}
            {!! Form::text('account_holder', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('bank_name', 'نام بانک :') !!}
            {!! Form::text('bank_name', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Form::label('card_number', 'شماره کارت :') !!}
        {!! Form::text('card_number', null, ['class' => 'form-control cc-formatter', 'required']) !!}
        {{-- <input type="text" class="form-control cc-formatter" name="card_number"
            id="cc-format" placeholder="Enter Credit Card Number" /> --}}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('iban', 'شبا :') !!}
            {!! Form::text('iban', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>





{!! Form::close() !!}

<script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>
