<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padoca Dona Inês - @yield('title', 'Página Inicial')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind.config.js') }}"></script>

    <!-- Box Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('assets/styles/global.css') }}">

    @stack('styles')
</head>

<body class="font-sans overflow-x-hidden scroll-smooth transition-all">
    <!-- Header para área do cliente -->
    @if(!request()->is('admin*'))
    @include('components.header')
    @endif

    @yield('content')

    @stack('scripts')
</body>

</html>