<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

{{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

{{-- Fontawesome --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">

{{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

{{-- Custom Styles --}}
    @yield('css')

</head>
<body>

{{-- wrapper --}}
<div class="d-flex" id="wrapper">

    {{-- Sidebar --}}
        <aside>
            @if (Auth::guard('web')->check())
                @component('layouts.components.UserSidebar')
                @endcomponent
            @endif
        </aside>
    {{-- Sidebar --}}

    {{-- Page Content Wrapper --}}
        <div id="page-content-wrapper">

        {{-- Navbar --}}
            <header>
                @component('layouts.components.UserNavbar')
                @endcomponent
            </header>
        {{-- Navbar --}}

        {{-- Content --}}
            <main class="container-fluid">
                @yield('content')
            </main>
        {{-- Content --}}

        </div>
    {{-- Page Content Wrapper --}}

    </div>
{{-- wrapper --}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}" type="module"></script>
    @yield('js')

</body>
</html>
