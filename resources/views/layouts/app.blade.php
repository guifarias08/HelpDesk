<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'HelpDesk')</title>

    <script>
        (function () {
            const savedTheme =
                localStorage.getItem('helpdesk-theme');

            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >
</head>

<body>

<header class="topbar">

    <div class="topbar-container">

        <a
            href="{{ route('dashboard') }}"
            class="brand"
        >
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
            aria-label="Abrir menu"
        >
            ☰
        </button>


        <nav
            class="main-nav"
            id="mainNav"
        >

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


        <div class="topbar-actions">

            <button
                type="button"
                id="themeToggle"
                class="theme-toggle"
                aria-label="Alterar tema"
            >
                🌙
            </button>

            <div class="user-avatar">
                AD
            </div>

        </div>

    </div>

</header>


<main class="app-container">

    @if(session('success'))

        <div class="alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <strong>
                Verifique os campos abaixo:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>

        </div>

    @endif


    @yield('content')

</main>


<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>