<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ✅ Correct CSS Loading -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <!-- ✅ Correct JavaScript Loading -->
    <script src="{{ asset('js/weather.js') }}?v={{ time() }}" defer></script>
</head>

<body>

<div class="container">
    @yield('content')
</div>

</body>
</html>
