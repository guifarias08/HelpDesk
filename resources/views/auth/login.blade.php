<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | HelpDesk</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --background: #06111f;
            --surface: #0b1b2e;
            --surface-light: #10243a;

            --border: rgba(148, 163, 184, 0.16);

            --primary: #3b82f6;
            --primary-hover: #2563eb;

            --text: #f8fafc;
            --text-secondary: #94a3b8;

            --danger: #fb7185;
            --success: #2dd4bf;
        }

        body {
            font-family:
                Inter,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            min-height: 100vh;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(59, 130, 246, .15),
                    transparent 35%
                ),
                var(--background);

            color: var(--text);
        }

        .page {
            min-height: 100vh;

            display: grid;

            grid-template-columns:
                minmax(400px, 1fr)
                minmax(450px, 1fr);
        }

        /* LADO ESQUERDO */

        .presentation {
            padding: 60px 8%;

            display: flex;
            flex-direction: column;

            border-right: 1px solid var(--border);

            background:
                linear-gradient(
                    135deg,
                    rgba(13, 35, 57, .9),
                    rgba(6, 17, 31, .9)
                );
        }

        .logo {
            display: flex;
            align-items: center;

            gap: 12px;
        }

        .logo-icon {
            width: 45px;
            height: 45px;

            display: grid;
            place-items: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #3b82f6,
                    #2563eb
                );

            font-size: 20px;
            font-weight: 800;

            box-shadow:
                0 10px 30px
                rgba(37, 99, 235, .25);
        }

        .logo strong {
            display: block;

            font-size: 20px;
        }

        .logo span {
            display: block;

            margin-top: 3px;

            color: var(--text-secondary);

            font-size: 9px;

            letter-spacing: 2px;

            text-transform: uppercase;
        }

        .presentation-content {
            margin: auto 0;

            max-width: 620px;
        }

        .badge {
            display: inline-block;

            padding: 8px 13px;

            margin-bottom: 25px;

            border-radius: 999px;

            border:
                1px solid
                rgba(59, 130, 246, .2);

            background:
                rgba(59, 130, 246, .1);

            color: #60a5fa;

            font-size: 12px;

            font-weight: 600;
        }

        .presentation h1 {
            font-size:
                clamp(
                    38px,
                    5vw,
                    65px
                );

            line-height: 1.05;

            letter-spacing: -3px;
        }

        .presentation p {
            margin-top: 25px;

            max-width: 520px;

            color: var(--text-secondary);

            line-height: 1.7;

            font-size: 15px;
        }

        .features {
            display: flex;
            flex-direction: column;

            gap: 18px;

            margin-top: 40px;
        }

        .feature {
            display: flex;
            align-items: center;

            gap: 14px;
        }

        .feature-icon {
            width: 34px;
            height: 34px;

            display: grid;
            place-items: center;

            border-radius: 9px;

            background:
                rgba(45, 212, 191, .08);

            color: var(--success);
        }

        .feature span {
            color: #cbd5e1;

            font-size: 13px;
        }

        /* LOGIN */

        .login-area {
            display: flex;

            align-items: center;
            justify-content: center;

            padding: 35px;
        }

        .login-card {
            width: 100%;

            max-width: 430px;

            padding: 38px;

            border:
                1px solid
                var(--border);

            border-radius: 18px;

            background:
                rgba(11, 27, 46, .82);

            box-shadow:
                0 30px 80px
                rgba(0, 0, 0, .3);
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 27px;

            letter-spacing: -.5px;
        }

        .login-header p {
            margin-top: 8px;

            color: var(--text-secondary);

            font-size: 13px;

            line-height: 1.6;
        }

        .alert-error {
            padding: 13px 14px;

            margin-bottom: 20px;

            border-radius: 10px;

            border:
                1px solid
                rgba(251, 113, 133, .2);

            background:
                rgba(251, 113, 133, .08);

            color: #fda4af;

            font-size: 12px;
        }

        .success {
            padding: 13px;

            margin-bottom: 20px;

            border-radius: 10px;

            background:
                rgba(45, 212, 191, .08);

            border:
                1px solid
                rgba(45, 212, 191, .18);

            color: #5eead4;

            font-size: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            color: #cbd5e1;

            font-size: 12px;

            font-weight: 600;
        }

        .input {
            width: 100%;

            height: 49px;

            padding: 0 14px;

            border-radius: 10px;

            border:
                1px solid
                rgba(148, 163, 184, .17);

            outline: none;

            background:
                rgba(5, 17, 31, .7);

            color: white;

            font-size: 13px;

            transition: .2s;
        }

        .input::placeholder {
            color: #475569;
        }

        .input:focus {
            border-color: var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(59, 130, 246, .08);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .input {
            padding-right: 55px;
        }

        .show-password {
            position: absolute;

            right: 13px;
            top: 50%;

            transform:
                translateY(-50%);

            border: none;

            background: transparent;

            color: #64748b;

            cursor: pointer;

            font-size: 12px;
        }

        .login-button {
            width: 100%;

            height: 50px;

            border: none;

            border-radius: 10px;

            cursor: pointer;

            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    var(--primary-hover)
                );

            color: white;

            font-size: 13px;

            font-weight: 700;

            box-shadow:
                0 10px 30px
                rgba(37, 99, 235, .25);

            transition: .2s;
        }

        .login-button:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 14px 35px
                rgba(37, 99, 235, .35);
        }

        .security {
            margin-top: 22px;

            text-align: center;

            color: #64748b;

            font-size: 10px;
        }

        @media (max-width: 900px) {

            .page {
                grid-template-columns: 1fr;
            }

            .presentation {
                display: none;
            }

            .login-area {
                min-height: 100vh;
            }

        }

        @media (max-width: 500px) {

            .login-area {
                padding: 20px;
            }

            .login-card {
                padding: 25px;

                border: none;

                background: transparent;

                box-shadow: none;
            }

        }

    </style>

</head>


<body>


<div class="page">


    {{-- Lado esquerdo --}}

    <section class="presentation">


        <div class="logo">

            <div class="logo-icon">
                H
            </div>

            <div>

                <strong>
                    HelpDesk
                </strong>

                <span>
                    Service Center
                </span>

            </div>

        </div>


        <div class="presentation-content">

            <span class="badge">
                Central de atendimento
            </span>


            <h1>

                Suporte mais simples.

                <br>

                Atendimento mais rápido.

            </h1>


            <p>

                Gerencie chamados, acompanhe atendimentos
                e mantenha sua equipe organizada em um único sistema.

            </p>


            <div class="features">

                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Gerenciamento centralizado de chamados
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Acompanhamento de prioridades e status
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>

                    <span>
                        Ambiente protegido por autenticação
                    </span>

                </div>

            </div>

        </div>


    </section>


    {{-- Login --}}

    <section class="login-area">


        <div class="login-card">


            <div class="login-header">

                <h2>
                    Bem-vindo
                </h2>

                <p>
                    Informe seu e-mail e senha para acessar o HelpDesk.
                </p>

            </div>




            {{-- Erros --}}

            @if ($errors->any())

                <div class="alert-error">

                    @foreach ($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                action="{{ route('login.store') }}"
                method="POST"
            >

                @csrf


                {{-- Email --}}

                <div class="form-group">

                    <label for="email">

                        E-mail

                    </label>


                    <input
                        class="input"
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="admin@helpdesk.com"
                        autocomplete="email"
                        autofocus
                        required
                    >

                </div>


                {{-- Senha --}}

                <div class="form-group">

                    <label for="password">

                        Senha

                    </label>


                    <div class="password-wrapper">

                        <input
                            class="input"
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Digite sua senha"
                            autocomplete="current-password"
                            required
                        >


                        <button
                            type="button"
                            class="show-password"
                            id="showPassword"
                        >

                            Mostrar

                        </button>

                    </div>

                </div>


                <button
                    class="login-button"
                    type="submit"
                >

                    Entrar no sistema →

                </button>


            </form>


            <div class="security">

                🔒 Acesso seguro ao HelpDesk

            </div>


        </div>


    </section>


</div>


<script>

    const password =
        document.getElementById('password');

    const showPassword =
        document.getElementById('showPassword');


    showPassword.addEventListener(
        'click',
        function () {

            if (password.type === 'password') {

                password.type = 'text';

                showPassword.textContent =
                    'Ocultar';

            } else {

                password.type = 'password';

                showPassword.textContent =
                    'Mostrar';

            }

        }
    );

</script>


</body>

</html>