@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-card-center">ویرایش اطلاعات</h4>
                    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
                            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
                            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                            {{--<li><a data-action="close"><i class="icon-cross2"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        {{--@if(isset($user))--}}
                        {!!Form::model($user,[ 'route' => ['admin.users.update' ],'method' => 'POST']) !!}
                        {{ Form::hidden('email', $user->email) }}
                        {{ Form::hidden('id', $user->id) }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'نام :') !!}
                                    {!! Form::text('name',null, ['class' => 'form-control','required']); !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('last_name', 'نام خانوادگی :') !!}
                                    {!! Form::text('last_name',null, ['class' => 'form-control','required']); !!}
                                </div>
                            </div>
                        </div>


                        {{--@if(isset($user))--}}
                        {{--<div class="row">--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="form-group">--}}
                        {{--{!! Form::label('email2', 'پست الکترونیک :') !!}--}}
                        {{--{!! Form::email('email2',null, ['class' => 'form-control','required']); !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="form-group">--}}
                        {{--{!! Form::label('phone', 'تلفن :') !!}--}}
                        {{--{!! Form::text('phone',null, ['class' => 'form-control','required']); !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                        {{--<div class="form-group">--}}
                        {{--{!! Form::label('wallet', 'کیف پول :') !!}--}}
                        {{--{!! Form::text('wallet',null, ['class' => 'form-control has-separator']); !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@else--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('phone', 'تلفن :') !!}
                                    {!! Form::text('phone',null, ['class' => 'form-control','required']); !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('wallet', 'کیف پول :') !!}
                                    {!! Form::text('wallet',null, ['class' => 'form-control has-separator']); !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('email2', 'پست الکترونیک :') !!}
                                    {!! Form::email('email2',null, ['class' => 'form-control','required']); !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('password', 'کلمه عبور :') !!}
                                    {!! Form::password('password', ['class' => 'form-control']); !!}
                                </div>
                            </div>
                        </div>
                        {{--@endif--}}
                        <div class="form-actions center">
                            <a href="{{route('admin.dashboard')}}" class="btn btn-warning mr-1">
                                <i class="icon-cross2"></i> انصراف
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-check2"></i> ثبت
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
