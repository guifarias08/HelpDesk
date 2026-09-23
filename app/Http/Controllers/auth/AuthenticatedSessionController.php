<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe a tela de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    /**
     * Realiza o login.
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validação
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'email.required' => 'Informe seu e-mail.',
                'email.email' => 'Informe um e-mail válido.',

                'password.required' => 'Informe sua senha.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Tentativa de login
        |--------------------------------------------------------------------------
        |
        | false = não manter usuário conectado permanentemente.
        |
        */

        if (! Auth::attempt($credentials, false)) {

            return back()
                ->withErrors([
                    'email' => 'E-mail ou senha incorretos.',
                ])
                ->onlyInput('email');
        }


        /*
        |--------------------------------------------------------------------------
        | Regenera sessão
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()->intended(
            route('dashboard')
        );
    }


    /**
     * Realiza logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Remove autenticação
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | Destrói sessão
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();


        /*
        |--------------------------------------------------------------------------
        | Novo token CSRF
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Volta para login
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login')
            ->with('success', 'Você saiu do sistema.');
    }
}