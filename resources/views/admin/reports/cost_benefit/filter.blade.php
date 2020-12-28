{!! Form::model(null, ['route' => ['admin.reports.cost-benefit-report'], 'method' => 'POST', 'id' =>
'cost-benefit-report']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('user_id', 'کاربر :') !!}
            {!! Form::select('user_id', $user_list, null, [
            'class' => 'form-control select2 single-select
            border-primary',
            'placeholder' => 'لطفا انتخاب کنید...',
            'required',
            'style' => 'width: 100%;',
            'id' => 'user',
            ]) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('portfolio_management_id', 'کالا :') !!}
            {!! Form::select('portfolio_management_id', $portfolio_management_list, null, [
            'class' => 'form-control select2
            single-select border-primary',
            'placeholder' => 'لطفا انتخاب کنید...',
            'required',
            'style' => 'width: 100%;',
            'id' => 'portfolio_management',
            ]) !!}
            {{-- {!! Form::select('good_id[]', $goods_list, null, ['class' =>
            'form-control js-example-basic-multiple', 'multiple' => 'multiple', 'style' => 'width: 100%;', 'id' =>
            'good_id']) !!} --}}

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="form-group ">
            {!! Form::label('start_date', ' تاریخ از :') !!}
            {!! Form::text('start_date', null, ['class' => 'form-control shamsi', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="form-group ">
            {!! Form::label('end_date', 'تا :') !!}
            {!! Form::text('end_date', null, ['class' => 'form-control shamsi', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}

<script></script>
