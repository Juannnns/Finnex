<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FINNEX') — Ecosistema Financiero Digital</title>
    <meta name="description" content="FINNEX — Tu ecosistema financiero digital. Organiza tus finanzas, recibe orientación y toma el control de tu futuro económico.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FINNEX CSS -->
    <link rel="stylesheet" href="{{ asset('css/finnex.css') }}">

    @stack('styles')
</head>
<body>

<div class="app-shell">

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        @include('components.topbar')

        <!-- Page Content -->
        <main class="page-content">
            @yield('content')
        </main>
    </div>
</div>

<!-- Floating FIN-BOT Button -->
<a href="{{ route('finbot') }}" class="a11y-toggle-btn" id="floating-finbot-btn" title="Chatear con FIN-BOT" aria-label="Abrir FIN-BOT">
    <img src="{{ asset('images/finbot.png') }}" alt="FIN-BOT Asistente" width="48" height="48">
</a>

<!-- Modals container -->
@stack('modals')

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>
<script src="{{ asset('js/accessibility.js') }}"></script>
@stack('scripts')

</body>
</html>
