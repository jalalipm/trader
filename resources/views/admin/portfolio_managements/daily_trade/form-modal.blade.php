@if (isset($portfolio_daily_trade))
    {!! Form::model($portfolio_daily_trade, ['route' => ['admin.portfolio_daily_trades.update'], 'method' => 'POST'])
    !!}
    {{ Form::hidden('id', $portfolio_daily_trade->id) }}
@else
    {!! Form::open(['route' => 'admin.portfolio_daily_trades.store', 'method' => 'POST']) !!}
@endif
{{ Form::hidden('portfolio_management_id', $portfolio_management_id) }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('shamsi_trade_date', 'تاریخ :') !!}
            {!! Form::text('shamsi_trade_date', isset($portfolio_daily_trade) ? $portfolio_daily_trade->trade_date :
            null, ['class' => 'shamsi form-control', 'required']) !!}

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('trade_nav', 'NAV روز :') !!}
            {!! Form::text('trade_nav', null, ['class' => 'form-control has-separator', 'required']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('trade_percent', 'درصد سود و زیان :') !!}
            {!! Form::text('trade_percent', null, ['class' => 'form-control has-separator-d0', 'required']) !!}
        </div>
    </div>
</div>





{!! Form::close() !!}

<script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>
<script>
    $('.shamsi').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        autoClose: true
    });

</script>
