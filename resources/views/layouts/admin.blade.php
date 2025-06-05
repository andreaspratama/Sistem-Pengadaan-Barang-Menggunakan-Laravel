<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @stack('prepend-style')  
    @include('includes.admin.style')
    @stack('addon-style')
</head>

<body>
    <script src="{{url('belakang/assets/static/js/initTheme.js')}}"></script>
    <div id="app">
        @include('includes.admin.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
        @yield('content')

            @include('includes.admin.footer')>
        </div>
    </div>
    @stack('prepend-script')
    @include('includes.admin.script')
    @stack('addon-script')

</body>

</html>