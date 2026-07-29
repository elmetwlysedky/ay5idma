<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('dashboard') }}</title>

    <!--favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>

<!-- ============================================
     CSS ORDER - Core → Libraries → Custom
     ============================================ -->

<!-- 1. CORE FRAMEWORK (Bootstrap must be first) -->
<link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

<!-- 2. FONT AWESOME (icons) -->
<link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css') }}">

<!-- 3. OTHER ICON SETS (if any) -->
<link rel="stylesheet" href="{{ url('assets/css/icons.css') }}">

<!-- 4. THIRD-PARTY LIBRARIES / PLUGINS -->
<link rel="stylesheet" href="{{ url('assets/css/jquery.timepicker.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ url('assets/css/toastr.min.css') }}">

<!-- 5. YOUR CUSTOM ADMIN CSS (LAST to override everything) -->
<link rel="stylesheet" href="{{ url('assets/css/admin.css') }}">

<!-- 6. RTL OVERRIDE (if applicable - must be last) -->
@if(app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ url('assets/css/admin.app.rtl.css') }}">
@endif

</head>

<body class="app ">

<!--Header Style -->
<div class="wave -three"></div>

<!--loader -->
<div id="spinner"></div>

<!--app open-->
<div id="app" class="page">
    <div class="main-wrapper">

        <!--nav open-->
        <nav class="navbar navbar-expand-lg main-navbar">
            <a class="header-brand" href="{{ route('admin.home.index') }}">
                <img src="{{ url('assets/img/Icons/logo.png') }}" class="header-brand-img" alt="Splite-Admin  logo">
            </a>
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-2">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link toggle"><i class="fa fa-reorder"></i></a>
                    </li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link d-md-none navsearch"><i
                                class="fa fa-search"></i></a></li>
                </ul>
                {{--<div class="search-element mr-3">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <span class="Search-icon"><i class="fa fa-search"></i></span>
                </div>--}}
            </form>
            <ul class="navbar-nav nav bar-right">
                <li class="dropdown dropdown-list-toggle d-none d-lg-block ">
                    <a href="#" data-toggle="dropdown" class="nav-link  nav-link-lg "><i class=" fa fa-flag-o "></i></a>
                    <div class="dropdown-menu dropdown-menu-lg  dropdown-menu-right">

                        @foreach (Config::get('app.locales') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <a href="{{ route(Route::currentRouteName(), array_merge( request()->route()->parameters(), ['lang' => $lang])) }}"
                                   class="dropdown-item d-flex align-items-center">
                                    <div>
                                        <strong>{{$language}}</strong>
                                    </div>
                                </a>
                            @endif
                        @endforeach

                    </div>
                </li>

                <li class="dropdown dropdown-list-toggle d-none d-lg-block">
                    <a href="#" class="nav-link nav-link-lg full-screen-link">
                        <i class="fa fa-expand " id="fullscreen-button"></i>
                    </a>
                </li>
                <li class="dropdown"><a href="#" data-toggle="dropdown"
                                        class="nav-link dropdown-toggle nav-link-lg d-flex">
                                <span class="mr-3 mt-2 d-none d-lg-block ">
                                    <span class="text-white">{{trans('hello')}},<span
                                            class="ml-1">{{auth()->user()->first_name.' '.auth()->user()->last_name}}</span></span>
                                </span>
                        <span>
                                    <img src="{{ asset( auth()->user()->image) }}"
                                         alt="{{auth()->user()->first_name.' '.auth()->user()->last_name}}"
                                         class="rounded-circle w-32 mr-2">
                                </span>
                    </a>
                    <div class="dropdown-menu ">
                        {{--
                        <a class="dropdown-item" href="profile.html"><i class="mdi mdi-account-outline mr-2"></i><span>My profile</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-settings mr-2"></i><span>Settings</span></a>
                        <a class="dropdown-item" href="#"><i class=" mdi mdi-message-outline mr-2"></i> <span>Mails</span></a>
                        <a class="dropdown-item" href="#"><i class=" mdi mdi-account-multiple-outline mr-2"></i> <span>Friends</span></a>
                        <a class="dropdown-item" href="#"><i class="fe fe-calendar mr-2"></i> <span>Activity</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-compass-outline mr-2"></i> <span>Support</span></a>
                        --}}
                        <a class="dropdown-item" href="{{ route('web.auth.logout') }}"><i
                                class="mdi  mdi-logout-variant mr-2"></i> <span>{{trans('logout')}}</span></a>
                    </div>
                </li>
            </ul>
        </nav>
        <!--nav closed-->

        <!--aside open-->

    @yield('sidebar', View::make('admin.sidebar'))
    <!--aside closed-->

         <div class="main-content">
            @yield('content')
        </div>

    <!--Footer-->
        <footer class="main-footer">
            <div class="text-center">
                Copyright &copy;Lodex 2016. Design By<a href="http://www.lodex-solutions.com"> Lodex</a>
            </div>
        </footer>
        <!--/Footer-->

        <!-- Popupchat open-->
        <div class="popup-box chat-popup" id="qnimate">
            <div class="popup-head">
                <div class="popup-head-left pull-left"><img src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                                                            alt="iamgurdeeposahan" class="mr-2"> Alica Nestle
                </div>
                <div class="popup-head-right pull-right">
                    <div class="btn-group">
                        <button class="chat-header-button" data-toggle="dropdown" type="button" aria-expanded="false">
                            <i class="glyphicon glyphicon-cog"></i></button>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                            <li><a href="#">Media</a></li>
                            <li><a href="#">Block</a></li>
                            <li><a href="#">Clear Chat</a></li>
                            <li><a href="#">Email Chat</a></li>
                        </ul>
                    </div>
                    <button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button"><i
                            class="glyphicon glyphicon-off"></i></button>
                </div>
            </div>
            <div class="popup-messages">
                <div class="direct-chat-messages">
                    <div class="chat-box-single-line">
                        <abbr class="timestamp">December 15th, 2018</abbr>
                    </div>
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left">Alica Nestle</span>
                            <span class="direct-chat-timestamp float-right">7:40 Am</span>
                        </div>
                        <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                             alt="message user image">
                        <div class="direct-chat-text">
                            Hello. How are you today?
                        </div>
                    </div>
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-right">Roberts</span>
                            <span class="direct-chat-timestamp float-left">8:05 Am</span>
                        </div>
                        <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-2.jpeg') }}"
                             alt="message user image">
                        <div class="direct-chat-text">
                            I'm fine. Thanks for asking!
                        </div>
                    </div>
                    <div class="chat-box-single-line  mb-3">
                        <abbr class="timestamp">December 14th, 2018</abbr>
                    </div>
                    <div class="direct-chat-msg doted-border">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left">Alica Nestle</span>
                            <span class="direct-chat-timestamp float-right">6:20 Am</span>
                        </div>
                        <img alt="iamgurdeeposahan" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                             class="direct-chat-img"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            Hey bro, how’s everything going ?
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name float-right">Roberts</span>
                                <span class="direct-chat-timestamp float-left">7:05 Am</span>
                            </div>
                            <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-2.jpeg') }}"
                                 alt="message user image">
                            <div class="direct-chat-text">
                                Nothing Much!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-messages-footer">
                <textarea id="status_message" placeholder="Type a message..." rows="10" cols="40"
                          name="message"></textarea>
                <div class="btn-footer">
                    <button class="bg_none"><i class="glyphicon glyphicon-film"></i></button>
                    <button class="bg_none"><i class="glyphicon glyphicon-camera"></i></button>
                    <button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i></button>
                    <button class="bg_none pull-right"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                </div>
            </div>
        </div>
        <!-- Popupchat closed -->

    </div>
</div>
<!--app closed-->

<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>
{{-- ============ CORE (always needed) ============ --}}
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

{{-- jQuery UI (sortable) --}}
<script src="{{ asset('assets/plugins/jquery-ui-draggabel/jquery-ui.min.js') }}"></script>

{{-- Select2 --}}
<script src="{{ asset('assets/plugins/select2/select2.full.js') }}"></script>

{{-- SumoSelect --}}
<script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

{{-- Inputmask --}}
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.js') }}"></script>

{{-- Accordion Wizard --}}
<script src="{{ asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>

{{-- Bootstrap Datepicker --}}
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

{{-- Moment (must load before Tempus Dominus) --}}
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

{{-- Tempus Dominus Datetimepicker --}}
<script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js') }}"></script>

{{-- jQuery Transfer --}}
<script src="{{ asset('assets/plugins/jQuerytransfer/jquery.transfer.js') }}"></script>

{{-- mCustomScrollbar --}}
<script src="{{ asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

{{-- Multi select / iCheck / Rating --}}

<script src="{{ asset('assets/plugins/iCheck/icheck.js') }}"></script>
<script src="{{ asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>

{{-- Bootstrap / Popper (core UI) --}}
<script src="{{ asset('assets/js/popper.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

{{-- Core template JS (menus, sidebar, tooltips, general UI — not chart/widget specific) --}}
<script src="{{ asset('assets/js/jquery.showmore.js') }}"></script>
<script src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.tree.js') }}"></script>
<script src="{{ asset('assets/js/accordiation.js') }}"></script>
<script src="{{ asset('assets/js/advancedform.js') }}"></script>
<script src="{{ asset('assets/js/dataclick.js') }}"></script>
<script src="{{ asset('assets/js/dragable.js') }}"></script>
<script src="{{ asset('assets/js/editable.js') }}"></script>
<script src="{{ asset('assets/js/formeditor.js') }}"></script>

<script src="{{ asset('assets/js/forms.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/tooltip.js') }}"></script>
<script src="{{ asset('assets/js/tree view.js') }}"></script>
<script src="{{ asset('assets/js/chattype.js') }}"></script>
@yield('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.side-menu [data-toggle="slide"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var parentLi = this.closest('li.slide');
            var wasOpen = parentLi.classList.contains('active');

            // close all other open dropdowns (accordion behavior)
            document.querySelectorAll('.side-menu li.slide.active').forEach(function (li) {
                li.classList.remove('active');
            });

            // reopen this one if it wasn't already open
            if (!wasOpen) {
                parentLi.classList.add('active');
            }
        });
    });
});
</script>
</body>
</html>
