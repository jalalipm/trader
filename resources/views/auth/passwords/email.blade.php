@extends('layouts.frontend')
@section('content')
    {{--<section class="flexbox-container">
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
                        <form class="form-horizontal" method="POST" action="{{route('post.sendResetLinkEmail')}}" novalidate>
                            {{csrf_field()}}
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="email" class="form-control form-control-lg input-lg" name="email" id="user-email" placeholder="پست الکترونیک " required>
                                <div class="form-control-position">
                                    <i class="icon-mail6"></i>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-lock4"></i> بازیابی کلمه عبور</button>
                        </form>
                    </div>
                </div>
                <div class="card-footer no-border">
                    <p class="float-sm-left text-xs-center"><a href="{{route('login')}}" class="card-link">ورود به سایت</a></p>
                    <p class="float-sm-right text-xs-center"> <a href="{{route('register')}}" class="card-link">عضویت در سایت</a></p>
                </div>
            </div>
        </div>
    </section>--}}
    <section class="flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                    <div class="card-header border-0 pb-0">
                        <div class="card-title text-center">
                            <img src="../../../app-assets/images/logo/logo-dark.png" alt="branding logo">
                        </div>
                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                            <span>یک آدرس برای بازیابی کلمه عبور برای شما ارسال می شود.</span>
                        </h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{route('post.sendResetLinkEmail')}}" novalidate>
                                {{csrf_field()}}
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="email" class="form-control form-control-lg input-lg" name="email" id="user-email" placeholder="پست الکترونیک " required>
                                    <div class="form-control-position">
                                        <i class="ft-mail"></i>
                                    </div>
                                </fieldset>
                                <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> بازیابی کلمه عبور</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        {{--<p class="float-sm-left text-center"><a href="login-simple.html" class="card-link">Login</a></p>--}}
                        {{--<p class="float-sm-right text-center">New to Robust ? <a href="register-simple.html" class="card-link">Create Account</a></p>--}}
                        <p class="float-sm-none text-center"><a href="{{route('login')}}" class="card-link">ورود به سایت</a></p>
{{--                        <p class="float-sm-right text-center"> <a href="{{route('register')}}" class="card-link">عضویت در سایت</a></p>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
