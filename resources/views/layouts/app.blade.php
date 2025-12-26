<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CodeCraft | Full-Stack Development & Premium Code Products')</title>

    @if($favicon = \App\Models\SiteSetting::get('site_favicon'))
        <link rel="icon" href="{{ asset($favicon) }}" type="image/x-icon">
    @endif

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @include('partials.styles')
    @stack('styles')
</head>

<body>
    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scripts -->
    @include('partials.scripts')
    @stack('scripts')
</body>

</html>