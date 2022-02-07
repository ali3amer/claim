<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Homepage</title>
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dashboard/css/main.css') }}"/>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/printThis.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('dashboard/css/table.css') }}"/>

</head>
<body class="rtl">
<div class="page home-page" id="app">
    @include('dashboard.sidebar')

    <div class="content-area">
        <div class="header pb-5">

            <a class="usermenu-container btn btn-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class="fa fa-power-off"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

