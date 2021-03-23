<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Signup</title>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="/template/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="/template/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="/template/index2.html" class="h1"><b>SIGNUP</b></a>
    </div>
    <div class="card-body">
    <p class="login-box-msg">Register a new membership</p>
    <form action="{{ route('auth.signup') }}" method="post">
        @csrf
        <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Full name" name="name">
        <div class="input-group-append">
            <div class="input-group-text">
            <span class="fas fa-user"></span>
            </div>
        </div>
        </div>
        <div class="input-group mb-3">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <div class="input-group-append">
            <div class="input-group-text">
            <span class="fas fa-envelope"></span>
            </div>
        </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <div class="input-group-append">
            <div class="input-group-text">
            <span class="fas fa-lock"></span>
            </div>
        </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Retype password" name="confirm">
        <div class="input-group-append">
            <div class="input-group-text">
            <span class="fas fa-lock"></span>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
        </div>
    </form>

    <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
    </div>
</div>
</div>
<script src="/template/plugins/jquery/jquery.min.js"></script>
<script src="/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/template/dist/js/adminlte.min.js"></script>
</body>
</html>
