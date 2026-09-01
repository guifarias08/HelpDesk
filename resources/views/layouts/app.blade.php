<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>@yield('title', 'HelpDesk')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<header class="topbar">

    <div class="topbar-container">

        <a href="{{ route('dashboard') }}" class="brand">
            <div class="brand-icon">
                H
            </div>

            <span>
                Help<span>Desk</span>
            </span>
        </a>

        <button
            type="button"
            class="menu-button"
            id="menuButton"
        >
            ☰
        </button>

        <nav class="main-nav" id="mainNav">

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                Dashboard
            </a>

            <a
                href="{{ route('tickets.index') }}"
                class="{{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') ? 'active' : '' }}"
            >
                Chamados
            </a>

            <a
                href="{{ route('tickets.create') }}"
                class="{{ request()->routeIs('tickets.create') ? 'active' : '' }}"
            >
                Novo chamado
            </a>

        </nav>
            <button type="button" id="themeToggle" class="theme-toggle">🌙</button> 
            <script>
    if (localStorage.getItem('helpdesk-theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>
</header>


<main class="app-container">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

</main>


<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>