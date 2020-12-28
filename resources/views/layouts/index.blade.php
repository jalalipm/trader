<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="گروه نرم افزاری سپارش ، پکیج آنلاین سرمایه گذاری خرد سپارش">
    <meta name="keywords" content="گروه نرم افزاری سپارش ، پکیج آنلاین سرمایه گذاری خرد سپارش">
    <meta name="author" content="separesh.shop">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ورود به نرم افزار سپارش</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Muli:300,400,500,700"
        rel="stylesheet">

    {{--
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/vendors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/weather-icons/climacons.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/app.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/custom-rtl.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css-rtl/plugins/calendars/clndr.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/fonts/meteocons/style.min.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style-rtl.css">
    <!-- END Custom CSS--> --}}

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/vendors.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/weather-icons/climacons.min.css') }}">
    <!-- END VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/fonts.css') }}">
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/custom-css.css?1') }}">
    --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/pace.css') }}">
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css') }}">
    <!-- END ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/wizard.css') }}">
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/calendars/clndr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fonts/meteocons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/icheck.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/icheck/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/checkboxes-radios.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/noui-slider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-noui.css') }}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-rtl.css') }}">
    <!-- END Custom CSS-->

    <!-- BEGIN DatePicker CSS-->
    <link rel="stylesheet" href="{{ asset('css/base/datepicker/persian-datepicker.min.css') }}" />
    <!-- END DatePicker CSS-->

    @yield('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datatable/fixedColumns.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/base/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/iziToast.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.2.1/css/bootstrap-slider.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/base/custom-css.css') }}">

</head>

<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu" data-col="2-columns">
    <input type="hidden" name="field_name" id="user-info" value="{{ \Illuminate\Support\Facades\Auth::id() }}"
        data-push-route="{{ route('admin.users.push-update') }}">
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="index.html">
                            <img class="brand-logo" alt="robust admin logo"
                                src="../../../app-assets/images/logo/logo-light-sm.png">
                            <h3 class="brand-text">سپارش</h3>
                        </a>
                    </li>
                    <li class="nav-item d-md-none">
                        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                                class="fa fa-ellipsis-v"> </i> </a>
                    </li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"> <a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                href="#"><i class="ft-menu"> </i> </a> </li>
                        <li class="nav-item d-none d-md-block"> <a class="nav-link nav-link-expand" href="#"> <i
                                    class="ficon ft-maximize"> </i> </a> </li>
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <span class="avatar avatar-online">
                                    <img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar">
                                    <i> </i> </span>
                                <span class="user-name">
                                    {{ \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->name : 'کاربر' }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i
                                        class="ft-user"></i> Edit Profile</a>
                                <a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a>
                                <a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a><a
                                    class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item"
                                    href="{{ route('logout') }}"><i class="ft-power"></i> خروج </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item">
                    <a href="index.html">
                        <i class="icon-home"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">داشبورد</span>
                        {{-- <span
                            class="badge badge badge-info badge-pill float-right mr-2">5</span>
                        --}}
                    </a>
                    <ul class="menu-content">
                        <li class="active1"><a class="menu-item" href="{{ route('admin.dashboard') }}"
                                data-i18n="nav.dash.ecommerce">داشبورد</a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header">
                    <span data-i18n="nav.category.layouts">اطلاعات پایه</span><i class="ft-more-horizontal ft-minus"
                        data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
                </li>
                <li class=" nav-item">
                    <a href="index.html">
                        <i class="icon-layers"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">عمومی</span>
                    </a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.users.list') }}"
                                data-i18n="nav.dash.ecommerce">کاربر</a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li> <a class="menu-item" href="{{ route('admin.portfolio_managements.list') }}"
                                data-i18n="nav.dash.ecommerce">سبد گردان</a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.faqs.list') }}" data-i18n="nav.dash.ecommerce">
                                پرسش های متداول </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.payments.list') }}"
                                data-i18n="nav.dash.ecommerce">
                                لیست تراکنش ها </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.messages.list') }}"
                                data-i18n="nav.dash.ecommerce">
                                پیام ها </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.user_tickets.list') }}"
                                data-i18n="nav.dash.ecommerce">
                                پشتیبانی </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.refund_requests.list') }}"
                                data-i18n="nav.dash.ecommerce">
                                درخواست تسویه </a>
                        </li>
                    </ul>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item" href="{{ route('admin.reports.list') }}"
                                data-i18n="nav.dash.ecommerce">
                                گزارش سود و زیان کاربر بر اساس سبدگردان </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">

                @yield('content')

            </div>
        </div>
    </div>

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    {{-- <footer class="footer footer-static footer-light navbar-border">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
            <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2018 <a
                    class="text-bold-800 grey darken-2"
                    href="https://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT
                </a>, All rights reserved. </span>
            <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Hand-crafted & Made with <i
                    class="ft-heart pink"></i></span>
        </p>
    </footer> --}}

    {{--
    <!-- BEGIN VENDOR JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="../../../app-assets/vendors/js/charts/raphael-min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/charts/morris.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/charts/chart.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js" type="text/javascript">
    </script>
    <script src="../../../app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js" type="text/javascript">
    </script>
    <script src="../../../app-assets/vendors/js/extensions/moment.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/extensions/underscore-min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/extensions/clndr.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/js/extensions/unslider-min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="../../../app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="../../../app-assets/js/core/app.js" type="text/javascript"></script>
    <script src="../../../app-assets/js/scripts/customizer.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="../../../app-assets/js/scripts/pages/dashboard-ecommerce.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS--> --}}


    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/underscore-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/clndr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/unslider-min.js') }}" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/jquery.steps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
    <!-- BEGIN DATA TABLE JS-->
    <script src="{{ asset('js/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/fnStandingRedraw.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('js/datatable/buttons.flash.min.js') }}"
        type="text/javascript"></script> --}}
    <script src="{{ asset('js/datatable/buttons.html5.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/buttons.print.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/dataTables.buttons.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/jszip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/jquery.easing.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/buttons.colVis.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/datatable/dataTables.fixedColumns.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/editors/ckeditor/ckeditor.js') }}"></script>
    <!-- END DATA TABLE JS-->
    <!-- BEGIN DatePicker JS-->
    <script src="{{ asset('js/base/datepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('js/base/datepicker/persian-datepicker.min.js') }}"></script>
    <!-- END DatePicker JS-->
    <script src="{{ asset('js/base/iziToast.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/base/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/base/select2/i18n/fa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/base/jquery.printPage.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/wNumb.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/nouislider.min.js') }}"></script>

    <script src="{{ asset('js/base/firebase/firebase-app.js') }}"></script>
    <script src="{{ asset('js/base/firebase/firebase-messaging.js') }}"></script>
    <script src="{{ asset('js/base/firebase/init.js') }}"></script>

    @yield('jscontent')

    <!-- BEGIN ROBUST JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/checkbox-radio.min.js') }}"></script>
    <script src="../../../app-assets/js/scripts/navs/navs.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <script src="{{ asset('js/base/custom-js.js') }}" type="text/javascript"></script>
</body>

</html>
