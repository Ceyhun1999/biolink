<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/additionals.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/colors.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/highslide.css') }}">
    <style>
        input[type="checkbox"][name="remember"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-right: 8px;
            vertical-align: middle;
            margin-top: 0;
        }

        input[type="checkbox"][name="remember"]:checked {
            accent-color: #1c1d1c;
        }

        .checkbox-inline {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .checker {
            display: inline-block;
        }

        .checker span {
            display: inline-block;
        }
    </style>
</head>

<body class="login-container pace-done sidebar-xs-indicator">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
            style="transform: translate3d(100%, 0px, 0px);">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <div class="page-container" style="min-height:695px">
        <div class="page-content">
            <div class="content-wrapper">
                <div class="content">
                    <form action="{{ route('admin.authenticate') }}" method="post" accept-charset="utf-8"
                        autocomplete="on">
                        @csrf

                        <div class="panel panel-body login-form">


                            <div class="text-center mb-20">
                                <img src="https://biolink.az/img/biolink.png" width="200">
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="form-group has-feedback has-feedback-left">
                                <span>Login:</span>
                                <input type="text" name="name" value=""
                                    class="mt-5 form-control input-roundless" placeholder="Login" autocomplete="name"
                                    autofocus>

                                <div class="form-control-feedback">
                                </div>
                            </div>
                            <div class="form-group has-feedback has-feedback-left">
                                <span>Şifrə:</span>
                                <input type="password" name="password" value="" autocomplete="password"
                                    class="mt-5 form-control input-roundless" placeholder="Password">

                                <div class="form-control-feedback">
                                </div>
                            </div>
                            <div class="form-group login-options">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="remember" value="1" id="remember">
                                            Yaddaşda saxla
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Hesaba daxil ol"
                                    style="background: #1c1d1c;border: 1px solid #1c1d1c;padding: 20px; border-radius: 14px;"
                                    class="btn btn-primary input-roundless color-microsoft btn-block">

                            </div>
                        </div>
                    </form>
                    <div class="footer text-muted text-center">© 2025. Biolink Version: 2.2.5</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
