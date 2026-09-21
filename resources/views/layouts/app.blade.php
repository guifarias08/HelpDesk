<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#08111d">
    <title>@yield('title', 'HelpDesk')</title>
    <script>
        (() => {
            const theme = localStorage.getItem('helpdesk-theme');
            if (theme === 'light' || (!theme && matchMedia('(prefers-color-scheme: light)').matches)) {
                document.documentElement.classList.add('light');
            }
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body>
    <a class="skip-link" href="#mainContent">Pular para o conteúdo</a>
    <div class="route-progress" id="routeProgress" aria-hidden="true"><span></span></div>

    <header class="topbar">
        <div class="topbar-inner">
            <a href="{{ route('dashboard') }}" class="brand" aria-label="HelpDesk — início">
                <span class="brand-logo">H</span>
                <span class="brand-text"><strong>HelpDesk</strong><small>Service Center</small></span>
            </a>

            <nav class="main-nav" id="mainNav" aria-label="Navegação principal">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">⌂</span> Visão geral
                </a>
                <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.index', 'tickets.show') ? 'active' : '' }}">
                    <span class="nav-icon">▤</span> Chamados
                </a>
                <a href="{{ route('tickets.board') }}" class="{{ request()->routeIs('tickets.board') ? 'active' : '' }}">
                    <span class="nav-icon">▦</span> Quadro
                </a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <span class="nav-icon">◇</span> Categorias
                </a>
            </nav>

            <div class="topbar-actions">
                <a href="{{ route('tickets.create') }}" class="header-create {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                    <span>＋</span> Novo chamado
                </a>
                <button type="button" id="themeToggle" class="icon-button" aria-label="Alternar tema" title="Alternar tema"></button>

                <div class="profile-menu-wrap">
                    <button type="button" id="profileButton" class="profile-button" aria-expanded="false" aria-controls="profileMenu">
                        <span class="profile-avatar">AD</span>
                        <span class="profile-info"><strong>Administrador</strong><small>Admin</small></span>
                        <span class="profile-chevron">⌄</span>
                    </button>
                    <div class="profile-menu" id="profileMenu" hidden>
                        <div class="profile-menu-header"><strong>Administrador</strong><span>Operação do sistema</span></div>
                        <a href="{{ route('categories.index') }}"><span>◇</span> Gerenciar categorias</a>
                        <div class="profile-menu-status"><i></i> Sistema operacional</div>
                    </div>
                </div>
            </div>

            <button type="button" id="menuButton" class="menu-button" aria-label="Abrir menu" aria-expanded="false" aria-controls="mainNav">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <main class="app-shell" id="mainContent">
        @yield('content')
    </main>

    <footer class="app-footer">
        <span>HelpDesk Service Center</span>
        <span class="system-status"><i></i> Todos os serviços operacionais</span>
    </footer>

    <div class="toast-region" id="toastRegion" aria-live="polite" aria-atomic="true">
        @if(session('success'))
            <div class="toast toast-success" role="status" data-toast>
                <span class="toast-icon">✓</span>
                <div><strong>Concluído</strong><p>{{ session('success') }}</p></div>
                <button type="button" class="toast-close" data-toast-close aria-label="Fechar aviso">×</button>
                <span class="toast-timer"></span>
            </div>
        @endif
        @if(session('error'))
            <div class="toast toast-error" role="alert" data-toast>
                <span class="toast-icon">!</span>
                <div><strong>Não foi possível concluir</strong><p>{{ session('error') }}</p></div>
                <button type="button" class="toast-close" data-toast-close aria-label="Fechar aviso">×</button>
                <span class="toast-timer"></span>
            </div>
        @endif
        @if($errors->any())
            <div class="toast toast-error" role="alert" data-toast>
                <span class="toast-icon">!</span>
                <div><strong>Revise os dados</strong><p>{{ $errors->first() }}</p></div>
                <button type="button" class="toast-close" data-toast-close aria-label="Fechar aviso">×</button>
                <span class="toast-timer"></span>
            </div>
        @endif
    </div>

    <dialog class="confirm-dialog" id="confirmDialog">
        <form method="dialog">
            <span class="confirm-icon">!</span>
            <h2 id="confirmTitle">Confirmar ação</h2>
            <p id="confirmMessage">Deseja continuar?</p>
            <div class="confirm-actions">
                <button value="cancel" class="btn btn-secondary">Cancelar</button>
                <button value="confirm" class="btn btn-danger">Confirmar</button>
            </div>
        </form>
    </dialog>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
</body>
</html>
