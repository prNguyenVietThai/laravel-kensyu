<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/template/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="/template/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="/template/plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="/template/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/template/plugins/ekko-lightbox/ekko-lightbox.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="/template/index3.html" class="navbar-brand">
            <img src="/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Laravel kensyu</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                <a href="{{ route('createPostPage') }}" class="nav-link">Create post</a>
                </li>
            </ul>
            <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                </div>
                </div>
            </form>
            </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                @auth
                    <li class="nav-item">
                        <div class="top-right links">
                            <a class="nav-link" href="{{ route('auth.logout') }}">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        <div>
                    </li>
                    @else
                    <li class="nav-item">
                        <div class="top-right links">
                            <a class="nav-link" href="{{ route('login') }}">
                                Login
                            </a>
                        <div>
                    </li>
                    <li class="nav-item">
                        <div class="top-right links">
                            <a class="nav-link" href="{{ route('signup') }}">
                                Signup
                            </a>
                        <div>
                    </li>
                @endauth
            </li>
            </ul>
        </div>
        </nav>
        @yield('content')
    </div>

    <script src="/template/plugins/jquery/jquery.min.js"></script>
    <script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/template/dist/js/adminlte.min.js"></script>
    <script src="/template/dist/js/demo.js"></script>
    <script src="/template/plugins/select2/js/select2.full.min.js"></script>
    <script src="/template/plugins/select2/js/select2.full.min.js"></script>
    <script src="/template/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="/template/plugins/moment/moment.min.js"></script>
    <script src="/template/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="/template/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/template/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="/template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/template/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="/template/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="/template/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="/template/dist/js/adminlte.min.js"></script>
    <script src="/template/dist/js/demo.js"></script>
    <script src="/template/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <script>
    $(function () {
        $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
    </script>
    <script>
    $(function () {
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
        });

        $('.filter-container').filterizr({gutterPixels: 3});
        $('.btn[data-filter]').on('click', function() {
        $('.btn[data-filter]').removeClass('active');
        $(this).addClass('active');
        });
    })
    </script>
</body>
</html>