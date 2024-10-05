<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Chat App') }}</title>
    <!-- Add your CSS files here -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @yield('content') <!-- This is where the content from other views will be injected -->
</div>
<!-- Add your JavaScript files here -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
