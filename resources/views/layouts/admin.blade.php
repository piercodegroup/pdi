<!DOCTYPE html>
<html lang="pt-br" x-data="{ sidebarOpen: window.innerWidth > 640 }" @resize.window="sidebarOpen = window.innerWidth > 640">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Padoca Dona Inês')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind.config.js') }}"></script>

    <!-- Box Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('assets/styles/global.css') }}">

    @stack('styles')
</head>

<body class="font-sans bg-gray-50">

    @include('components.admin.sidebar')

    <div class="pl-20">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>