{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Login') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                                @error('password')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row mb-0">--}}
{{--                            <div class="col-md-8 offset-md-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    {{ __('Login') }}--}}
{{--                                </button>--}}

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('login_design/style.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل دخول</title>
</head>
<body dir="rtl">
<div class="logo"></div>
<div class="box bg-img">
    <div class="content">
        <h2>تسجيل<span> دخول</span></h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
        <div class="forms">
            <div class="user-input">
                <input
                    type="text"
                    class="login-input @error('name') is-invalid @enderror" autocomplete="off"
                    placeholder="إسم المستخدم" name="name" value="{{ old('name') }}" autofocus
                    id="name"
                    required
                />
                <i class="fa fa-user"></i>

            </div>

            <div class="pass-input">
                <input
                    type="password"
                    class="login-input @error('password') is-invalid @enderror" required
                    placeholder="كلمة المرور" name="password"
                    id="my-password"
                    required
                />


                <span class="eye" onclick="myFunction()">
              <i id="hide-1" class="fa fa-eye-slash"></i>
              <i id="hide-2" class="fa fa-eye"></i>
            </span>
            </div>
        </div>


        <button class="login-btn" type="submit">تسجيل دخول</button>
        </form>
    </div>
</div>
<!-- <script
  src="https://kit.fontawesome.com/c0078485ae.js"
  crossorigin="anonymous"
></script> -->
<script src="{{ asset('login_design/js.js') }}"></script>
</body>
</html>

