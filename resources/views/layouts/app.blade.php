<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'HelpDesk')
    </title>


    <script>
        (function () {

            const savedTheme =
                localStorage.getItem('helpdesk-theme');

            if (savedTheme === 'dark') {

                document.documentElement
                    .classList
                    .add('dark');

            }

        })();
    </script>


    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

</head>


<body>


<header class="app-header">

    <div class="header-container">


        <a
            href="{{ route('dashboard') }}"
            class="brand"
        >

            <div class="brand-symbol">
                H
            </div>

            <div class="brand-name">

                HelpDesk

                <small>
                    Service Center
                </small>

            </div>

        </a>


        <nav
            class="desktop-nav"
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


        <div class="header-actions">


            <button
                type="button"
                id="themeToggle"
                class="icon-button"
                onclick="toggleTheme()"
                aria-label="Alternar tema"
            >
                ◐
            </button>


            <div class="profile-button">

                <div class="profile-avatar">
                    AD
                </div>


                <div class="profile-info">

                    <strong>
                        Administrador
                    </strong>

                    <span>
                        Admin
                    </span>

                </div>

            </div>

        </div>


        <button
            type="button"
            id="menuButton"
            class="mobile-menu-button"
        >
            ☰
        </button>


    </div>

</header>


<main class="page-container">


    @if(session('success'))

        <div class="alert alert-success">

            <strong>
                Sucesso
            </strong>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-error">

            <strong>
                Verifique os dados informados.
            </strong>

            @foreach($errors->all() as $error)

                <span>
                    {{ $error }}
                </span>

            @endforeach

        </div>

    @endif


    @yield('content')


</main>


<script src="{{ asset('js/app.js') }}"></script>


<script>

    function toggleTheme() {

        const html =
            document.documentElement;


        html.classList.toggle('dark');


        const isDark =
            html.classList.contains('dark');


        localStorage.setItem(
            'helpdesk-theme',
            isDark ? 'dark' : 'light'
        );


        updateThemeButton();

    }


    function updateThemeButton() {

        const button =
            document.getElementById('themeToggle');


        if (!button) {
            return;
        }


        const isDark =
            document.documentElement
                .classList
                .contains('dark');


        button.textContent =
            isDark
                ? '☀'
                : '◐';

    }


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            updateThemeButton();

        }
    );

</script>


</body>

</html>