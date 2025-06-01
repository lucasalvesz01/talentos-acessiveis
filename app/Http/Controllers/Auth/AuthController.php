<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;

// Certifique-se de importar o modelo User
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostra o formulário de registro.
     */
    public function showRegistrationForm(): Factory|View|Application
    {
        return view('register'); // Exibe a página de registro
    }

    /**
     * Processa o formulário de registro.
     */
    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'telefone' => ['required', 'string', 'max:20', 'regex:/^[\d\s\-\(\)]+$/'],
            'data_nascimento' => ['required', 'date', 'before:-18 years'],
            'sexo' => ['required', 'string', 'in:male,female,other'],
            'disability_type' => ['required', 'string', 'in:visual,auditory,physical,intellectual,none'],
            'password' => ['required', 'string', 'confirmed'],
            'interest_area' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'url'],
            'work_availability' => ['nullable', 'string', 'max:255'],
        ], [
            'data_nascimento.before' => 'Você deve ter pelo menos 18 anos para se registrar.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.confirmed' => 'As senhas não coincidem.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.form')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'phone' => $request->telefone,
            'birthdate' => $request->data_nascimento,
            'gender' => $request->sexo,
            'disability_type' => $request->disability_type,
            'password' => Hash::make($request->password),
            'interest_area' => $request->interest_area,
            'linkedin' => $request->linkedin,
            'work_availability' => $request->work_availability,
        ]);

        Auth::login($user);

        return redirect()->route('post')->with('success', 'Cadastro realizado com sucesso!');
    }

    /**
     * Mostra o formulário de login.
     */
    public function showLoginForm(): Factory|View|Application
    {
        return view('login');
    }

    /**
     * Processa o formulário de login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('post')->with('success', 'Login realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput();
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Logout realizado com sucesso!');
    }
}
