@extends('layouts.frontend')
@section('content');
<section class="flexbox-container">
    <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
        <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
            <div class="card-header no-border">
                <div class="card-title text-xs-center">
                    <img src="../../app-assets/images/logo/robust-logo-dark.png" alt="branding logo">
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>عضویت سریع در سایت</span></h6>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form-horizontal form-simple" method="POST" action="{{route('post.register')}}" novalidate>
                        {{ csrf_field() }}
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            <input type="text" class="form-control form-control-lg input-lg" name="name" id="user-name" placeholder="نام کاربری">
                            <div class="form-control-position">
                                <i class="icon-head"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left mb-1">
                            <input type="email" class="form-control form-control-lg input-lg" name="email" id="user-email" placeholder="پست الکترونیک" required>
                            <div class="form-control-position">
                                <i class="icon-mail6"></i>
                            </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control form-control-lg input-lg" name="password" id="user-password" placeholder="کلمه عبور" required>
                            <div class="form-control-position">
                                <i class="icon-key3"></i>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-unlock2"></i> عضویت</button>
                    </form>
                </div>
                <p class="text-xs-center">آیا قبلا ثبت نام کرده اید ؟ <a href="{{route("login")}}" class="card-link">ورود</a></p>
            </div>
        </div>
    </div>
</section>

@endsection