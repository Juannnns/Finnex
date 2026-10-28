<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iniciar sesión') — FINNEX</title>
    <meta name="description" content="Accede a FINNEX, tu ecosistema financiero digital.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FINNEX CSS -->
    <link rel="stylesheet" href="{{ asset('css/finnex.css') }}">
</head>
<body>

@yield('content')

<script src="{{ asset('js/accessibility.js') }}"></script>
@stack('scripts')

</body>
</html>
