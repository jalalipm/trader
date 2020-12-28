@extends('layouts.frontend')
@section('content')
    <section class="flexbox-container">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
                <div class="card border-grey border-lighten-3 m-0">
                    <div class="card-header border-0">
                        <div class="card-title text-center">
                            <div class="p-1">
                                <img src="../../../app-assets/images/logo/logo-dark.png" alt="branding logo">
                            </div>
                        </div>
                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                            <span>ورود به سایت</span>
                        </h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form-horizontal form-simple" method="POST" action="{{ route('post.login') }}"
                                novalidate>
                                {{ csrf_field() }}
                                <fieldset class="form-group position-relative has-icon-left mb-0">
                                    <input type="text" class="form-control form-control-lg input-lg" name="email" id="email"
                                        placeholder="نام کاربری" required>
                                    <div class="form-control-position">
                                        <i class="ft-user"></i>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input type="password" class="form-control form-control-lg input-lg" name="password"
                                        id="password" placeholder="کلمه عبور" required>
                                    <div class="form-control-position">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </fieldset>
                                <div class="form-group row">
                                    <div class="col-md-6 col-12 text-center text-md-left">
                                        <fieldset>
                                            <input type="checkbox" id="remember-me" class="chk-remember">
                                            <label for="remember-me"> مرا بخاطر بسپار</label>
                                        </fieldset>
                                    </div>
                                    {{-- <div
                                        class="col-md-6 col-12 text-center text-md-right"><a href="{{ route('reset') }}"
                                            class="card-link">بازیابی کلمه عبور</a></div> --}}
                                </div>
                                <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i>
                                    ورود</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="">
                            {{--<p class="float-sm-left text-center m-0"><a
                                    href="{{ route('reset') }}" class="card-link">بازیابی کلمه عبور</a></p>
                            --}}
                            {{--<p class="float-sm-right text-center m-0">New to Moden Admin?
                                <a href="register-simple.html" class="card-link">Sign Up</a>
                            </p>
                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
