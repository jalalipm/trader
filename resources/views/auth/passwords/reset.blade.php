@extends('layouts.frontend')
@section('content')
    <section class="flexbox-container">
        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                <div class="card-header no-border pb-0">
                    <div class="card-title text-xs-center">
                        <img src="../../app-assets/images/logo/robust-logo-dark.png" alt="branding logo">
                    </div>
                    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>یک آدرس برای بازیابی کلمه عبور برای شما ارسال می شود.</span></h6>
                </div>
                <div class="card-body collapse in">
                    <div class="card-block">
                        {{--<form class="form-horizontal" method="POST" action="{{route('post.reset')}}" novalidate>--}}
                        {{--                            {{csrf_field()}}--}}
                        {!! Form::open(['route' => 'password.reset' , 'method' => 'POST']) !!}

                        {!! Form::hidden('token',$token) !!}
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            {{--<input type="email" class="form-control form-control-lg input-lg" name="email" id="user-email" placeholder="پست الکترونیک" required>--}}
                            {!! Form::text('email',null, ['class' => 'form-control form-control-lg input-lg','placeholder'=>"پست الکترونیک"]); !!}
                            <div class="form-control-position">
                                <i class="icon-mail6"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            {{--<input type="password" class="form-control form-control-lg input-lg" name="password" id="user-password" placeholder="کلمه عبور" required>--}}
                            {!! Form::password('password', ['class' => 'form-control form-control-lg input-lg','placeholder'=>"کلمه عبور"]); !!}

                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            {{--<input type="password" class="form-control form-control-lg input-lg" name="password" id="user-password" placeholder="کلمه عبور" required>--}}
                            {!! Form::password('password_confirmation', ['class' => 'form-control form-control-lg input-lg','placeholder'=>"تکرار کلمه عبور"]); !!}

                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-lock4"></i> بازیابی کلمه عبور</button>
                        {!! Form::close() !!}

                        {{--</form>--}}
                    </div>
                </div>
                <div class="card-footer no-border">
                    <p class="float-sm-left text-xs-center"><a href="{{route('login')}}" class="card-link">ورود به سایت</a></p>
                    <p class="float-sm-right text-xs-center"> <a href="{{route('register')}}" class="card-link">عضویت در سایت</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection

{{--{!! Form::open(['url' => 'password/email' , 'method' => 'POST']) !!}--}}

{{--{!! Form::label('email', 'پست الکترونیک :') !!}--}}
{{--{!! Form::text('email',null, ['class' => 'form-control']); !!}--}}

{{--{!! Form::submit('بازیابی کلمه عبور' , ['class' => 'form-control' ]) !!}--}}

{{--{!! Form::close() !!}--}}
