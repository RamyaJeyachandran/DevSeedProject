<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/logo.svg') }}" rel="shortcut icon">
        <meta name="author" content="LEFT4CODE">
        <title>@yield('title')</title>
        <!-- BEGIN: CSS Assets-->
        @yield('style')
        <!-- END: CSS Assets-->
        <style>
            :root{
                --color-primary: {{ session('colorId')}};
            }
        </style>
    </head>
    <!-- END: Head -->
    <body class="py-5">
        @yield('content')
        @include('layouts.footer')
        @stack('js')        
    </body>
</html>