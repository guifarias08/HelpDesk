<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | HelpDesk Service Center</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

<div class="login-page">

    <div class="login-background">
        <div class="glow glow-1"></div>
        <div class="glow glow-2"></div>
    </div>

    <main class="login-wrapper">

        {{-- LADO ESQUERDO --}}
        <section class="login-brand">

            <div class="brand">

                <div class="brand-logo">
                    H
                </div>

                <div>
                    <h1>HelpDesk</h1>
                    <span>Service Center</span>
                </div>

            </div>

            <div class="brand-content">

                <span class="brand-badge">
                    Central de atendimento
                </span>

                <h2>
                    Suporte mais simples.<br>
                    Atendimento mais rápido.
                </h2>

                <p>
                    Gerencie chamados, acompanhe atendimentos
                    e mantenha sua equipe organizada em um único lugar.
                </p>

                <div class="features">

                    <div class="feature">

                        <div class="feature-icon">
                            ✓
                        </div>

                        <div>
                            <strong>Gerenciamento centralizado</strong>
                            <span>
                                Acompanhe todos os chamados em tempo real.
                            </span>
                        </div>

                    </div>

                    <div class="feature">

                        <div class="feature-icon">
                            ✓
                        </div>

                        <div>
                            <strong>Controle de atendimentos</strong>
                            <span>
                                Prioridades, responsáveis e status organizados.
                            </span>
                        </div>

                    </div>

                    <div class="feature">

                        <div class="feature-icon">
                            ✓
                        </div>

                        <div>
                            <strong>Ambiente seguro</strong>
                            <span>
                                Acesso restrito aos usuários autorizados.
                            </span>
                        </div>

                    </div>

                </div>

            </div>

            <div class="brand-footer">
                <span class="status-dot"></span>
                Sistema operacional
            </div>

        </section>


        {{-- LADO DIREITO --}}
        <section class="login-area">

            <div class="login-card">

                <div class="mobile-brand">

                    <div class="brand-logo">
                        H
                    </div>

                    <div>
                        <strong>HelpDesk</strong>
                        <span>Service Center</span>
                    </div>

                </div>


                <div class="login-header">

                    <div class="login-icon">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" x2="3" y1="12" y2="12"/>
                        </svg>

                    </div>

                    <h1>Bem-vindo de volta</h1>

                    <p>
                        Entre com suas credenciais para acessar o HelpDesk.
                    </p>

                </div>


                {{-- ERRO GERAL --}}
                @if ($errors->any())

                    <div class="alert-error">

                        <div class="alert-icon">!</div>

                        <div>
                            <strong>Não foi possível entrar</strong>

                            <span>
                                Verifique seu e-mail e senha e tente novamente.
                            </span>
                        </div>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('login.store') }}"
                    class="login-form"
                >

                    @csrf


                    {{-- EMAIL --}}
                    <div class="form-group">

                        <label for="email">
                            E-mail
                        </label>

                        <div class="input-wrapper">

                            <span class="input-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                                    <path d="m22 7-10 5L2 7"/>
                                </svg>

                            </span>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="seuemail@empresa.com"
                                autocomplete="email"
                                autofocus
                                required
                            >

                        </div>

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- SENHA --}}
                    <div class="form-group">

                        <div class="label-row">

                            <label for="password">
                                Senha
                            </label>

                            @if (Route::has('password.request'))

                                <a
                                    href="{{ route('password.request') }}"
                                    class="forgot-link"
                                >
                                    Esqueceu a senha?
                                </a>

                            @endif

                        </div>

                        <div class="input-wrapper">

                            <span class="input-icon">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <rect width="18" height="11" x="3" y="11" rx="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>

                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Digite sua senha"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                id="passwordToggle"
                                aria-label="Mostrar senha"
                            >

                                <svg
                                    id="eyeIcon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696C3.468 7.48 7.395 5 12 5c4.605 0 8.532 2.48 9.938 6.652a1 1 0 0 1 0 .696C20.532 16.52 16.605 19 12 19c-4.605 0-8.532-2.48-9.938-6.652"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                            </button>

                        </div>

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- LEMBRAR --}}
                    <div class="remember-row">

                        <label class="checkbox">

                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                            >

                            <span class="checkbox-box"></span>

                            Manter conectado

                        </label>

                    </div>


                    {{-- BOTÃO --}}
                    <button
                        type="submit"
                        class="login-button"
                    >

                        <span>Entrar no sistema</span>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>

                    </button>

                </form>


                <div class="login-security">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="14"
                        height="14"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M20 13c0 5-3.5 7.5-8 9-4.5-1.5-8-4-8-9V5l8-3 8 3z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>

                    Acesso seguro e protegido

                </div>

            </div>

            <footer class="login-footer">
                © {{ date('Y') }} HelpDesk Service Center
            </footer>

        </section>

    </main>

</div>


<script>

    const password = document.getElementById('password');
    const toggle = document.getElementById('passwordToggle');

    toggle.addEventListener('click', () => {

        const isPassword = password.type === 'password';

        password.type = isPassword ? 'text' : 'password';

        toggle.classList.toggle('active', isPassword);

        toggle.setAttribute(
            'aria-label',
            isPassword ? 'Ocultar senha' : 'Mostrar senha'
        );

    });

</script>

</body>
</html>