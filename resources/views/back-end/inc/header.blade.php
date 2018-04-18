<!doctype html>
<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Admin Page</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="{{ asset('back-end/css/vendor.css') }}">

        <!-- Theme initialization -->
        <link rel="stylesheet" href="{{ asset('back-end/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('back-end/css/common.css') }}">
        <script src="{{ asset('back-end/js/jquery-1.10.2.min.js') }}"></script>
        @yield('styles')
    </head>

    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                <header class="header">
                    <div class="header-block header-block-collapse hidden-lg-up">
                        <button class="collapse-btn" id="sidebar-collapse-btn"><i class="fa fa-bars"></i></button> 
                    </div>
                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">

                            <li class="profile dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="img"> </div> <span class="name">Admin</span>
                                </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="/admin/profile">
                                        <i class="fa fa-user icon"></i>
                                        Profile
                                    </a>
                                    {{--<a class="dropdown-item" href="#">--}}
                                        {{--<i class="fa fa-gear icon"></i>--}}
                                        {{--Settings--}}
                                    {{--</a>--}}
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}" 
                                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power-off icon"></i>
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>