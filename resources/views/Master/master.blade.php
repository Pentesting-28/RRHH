<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi Proyecto</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body >
<div id="app">
    <App></App>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
