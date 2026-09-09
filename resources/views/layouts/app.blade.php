<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'HelpDesk')</title>

    {{-- Carrega o tema antes da página aparecer --}}
    <script>
        (function () {
            const savedTheme = localStorage.getItem('helpdesk-theme');

            if (savedTheme === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}"
    >
</head>

<body>

<header class="topbar">

    <div class="topbar-inner">

        {{-- LOGO --}}
        <a
            href="{{ route('dashboard') }}"
            class="brand"
        >
            <div class="brand-logo">
                H
            </div>

            <div class="brand-text">
                <strong>HelpDesk</strong>
                <span>Service Center</span>
            </div>
        </a>


        {{-- NAVEGAÇÃO --}}
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


        {{-- AÇÕES --}}
        <div class="topbar-actions">

            <button
                type="button"
                id="themeToggle"
                class="theme-toggle"
                aria-label="Alternar tema"
            >
                ☀
            </button>

            <div class="topbar-divider"></div>

            <div class="profile">

                <div class="profile-avatar">
                    AD
                </div>

                <div class="profile-info">
                    <strong>Administrador</strong>
                    <span>Admin</span>
                </div>

            </div>

        </div>


        {{-- MOBILE --}}
        <button
            type="button"
            id="menuButton"
            class="menu-button"
            aria-label="Abrir menu"
        >
            ☰
        </button>

    </div>

</header>


<main class="app-shell">

    @if(session('success'))

        <div class="alert alert-success">

            <div class="alert-icon">
                ✓
            </div>

            <div>
                <strong>Sucesso</strong>
                <p>{{ session('success') }}</p>
            </div>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <div>
                <strong>Erro</strong>
                <p>{{ session('error') }}</p>
            </div>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <div>

                <strong>
                    Verifique os campos informados
                </strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        </div>

    @endif


    @yield('content')

</main>


<script
    src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"
></script>

</body>
</html>