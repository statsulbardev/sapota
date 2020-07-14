<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Bank Data Pembangunan Provinsi Sulawesi Barat">
    <meta name="author" content="BPS Provinsi Sulawesi Barat">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,600">
    <link rel="stylesheet" href="{{ asset('css/frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/vendor/lightbox2/css/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/appton/fontastic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/appton/style.blue.css') }}" id="theme-stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend/appton/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/icon/favicon.png') }}">
    @yield('style')
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
    @if(Auth::user())
        <script type="text/javascript">
            window.location = "{{ url('/admin') }}";
        </script>
    @else
    <header class="header">
            <nav class="navbar navbar-expand-lg fixed-top">
                <div class="container"><a href="/" class="navbar-brand"><img src="{{ asset('images/appton/logo.png') }}" alt=""></a>
                    <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                        class="navbar-toggler navbar-toggler-right">Menu<i class="fa fa-bars ml-2"></i>
                    </button>
                    <div id="navbarSupportedContent" class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="{{ route('show_landing_page') }}" id="btn"
                                    class="nav-link {{ (strcmp(Route::currentRouteName(), 'show_landing_page') == 0) ? 'active' : '' }}">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('show_data_page') }}" id="btn"
                                    class="nav-link {{ (strcmp(Route::currentRouteName(), 'show_data_page') == 0) ? 'active' : '' }}">Data</a>
                            </li>
                            <li class="nav_item">
                                <a href="{{ route('show_about_page') }}" id="btn"
                                    class="nav-link {{ (strcmp(Route::currentRouteName(), 'show_about_page') == 0) ? 'active' : '' }}">Tentang</a>
                            </li>
                        </ul>
                        <a href="{{ url('/admin') }}" class="btn btn-primary navbar-btn ml-0 ml-lg-3">Login</a>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')

        <footer class="main-footer bg-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="footer-logo bankdata">
                            <img src="{{ asset('images/appton/logo.png') }}" alt="logo bankdata">
                        </div>
                        <div class="pemprov bps" style="margin-top:3.5rem">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{ asset('images/appton/logo-pemprov.png') }}" alt="logo pemprov">
                                </div>
                                <div class="col-sm-6">
                                    <img style="float:right" src="{{ asset('images/appton/logo-bps.png') }}" alt="logo-bps">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <h5 class="footer-heading">Informasi</h5>
                            <ul class="list-unstyled">
                            <li> <a href="#" class="footer-link">Satu Data Indonesia</a></li>
                            <li> <a href="#" class="footer-link">Pengembangan</a></li>
                            <li> <a href="#" class="footer-link">Tentang</a></li>
                            <li> <a href="#" class="footer-link">Bantuan</a></li>
                            </ul>
                    </div>
                </div>
            </div>
            <div class="copyrights">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 text-center text-lg-left">
                            <p class="copyrights-text mb-3 mb-lg-0">&copy; BPS Provinsi Sulawesi Barat. Design by <a href="https://bootstrapious.com/p/big-bootstrap-tutorial" class="external footer-link">Bootstrapious</a></p>
                        </div>
                        <div class="col-lg-6 text-center text-lg-right">
                        <ul class="list-inline social mb-0">
                            <li class="list-inline-item">
                                <a href="#" class="social-link"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="social-link"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="social-link"><i class="fa fa-youtube-play"></i></a>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/frontend/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/frontend/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
        <script src="{{ asset('js/frontend/vendor/lightbox2/js/lightbox.js') }}"></script>
        <script src="{{ asset('js/frontend/appton/front.js') }}"></script>
        @stack('script')
    @endif
</body>
</html>