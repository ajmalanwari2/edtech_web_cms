<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="{{asset('assets/css/app-min.css')}}" />
</head>

<body class="layout-login-centered-boxed">
    <div class="layout-login-centered-boxed__form">
        <div class="d-flex flex-column justify-content-center align-items-center mt-2 mb-2 navbar-light">
            <a href="index.html" class="navbar-brand text-center mb-2 mr-0" style="min-width: 0">
                <!-- LOGO -->
                <img src="{{ asset('assets/frontend/images/logo.png') }}" width="100px"  height="100px" alt="Logo">

                <!-- <span class="ml-2">ED Tech</span> -->
            </a>
        </div>

        <div class="card card-body">
            @if (\Session::has('info'))
                <div class="alert alert-dismissible bg-info text-white border-0 fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <strong>Info - </strong> {!! \Session::get('info') !!}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    @if ($errors->has('identity_number'))
                        <span class="invalid-feedback" style="color: red;display:block">
                            <strong>{{ $errors->first('identity_number') }}</strong>
                        </span>
                    @endif
                    <label class="text-label" for="identity_number">Identity Number:</label>
                    <div class="input-group input-group-merge">
                        <input id="identity_number" name="identity_number" type="text" required=""
                            class="form-control form-control-prepended" placeholder="0800-245">

                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="far fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="text-label" for="password">Password:</label>
                    <div class="input-group input-group-merge">
                        <input id="password" type="password" name="password" required=""
                            class="form-control form-control-prepended" placeholder="Enter your password">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fa fa-key"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-block text-white" style="background-color: #006983" type="submit">Login</button>
                </div>
                <div class="form-group text-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" checked="" id="remember">
                        <label class="custom-control-label" for="remember">Remember me</label>
                    </div>
                </div>


                <!-- <div class="form-group text-center">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                    <br>
                    Don't have an account? <a class="text-body text-underline" href="{{ route('user.request') }}">Sign
                        up!</a>
                </div> -->



            </form>
        </div>
    </div>
</body>

</html>

