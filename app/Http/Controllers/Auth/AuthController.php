<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Mostra o formulário de registro.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Processa o formulário de registro.
     */
    public function register(Request $request): RedirectResponse
    {
        if ($request->filled('linkedin') && !preg_match('/^https?:\/\//', $request->linkedin)) {
            $request->merge([
                'linkedin' => 'https://' . $request->linkedin,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'telefone' => ['required', 'string', 'max:20'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'string', 'in:masculino,feminino,outro'],
            'disability_type' => ['required', 'string', 'in:visual,auditiva,fisica,intelectual,nenhuma'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'interest_area' => ['required', 'string', 'in:Tecnologia,Saúde,Educação,Finanças,Entretenimento,Esportes,Ciência,Arte'],
            'linkedin' => ['nullable', 'max:350'],
            'work_availability' => ['required', 'string', 'in:presencial,remoto,híbrido'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'disability_type' => $request->disability_type,
            'interest_area' => $request->interest_area,
            'linkedin' => $request->linkedin,
            'work_availability' => $request->work_availability,
            'password' => Hash::make($request->password),
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
    public function login(Request $request)
    {
        // Validação dos dados do formulário
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redireciona para a página de postagem após o login
            return redirect()->route('post')->with('success', 'Login realizado com sucesso!');
        }

        // Se falhar, retorna com mensagem de erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput();
    }

    /**
     * Realiza o logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida a sessão e regenera o token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redireciona para a página inicial após o logout
        return redirect()->route('welcome')->with('success', 'Logout realizado com sucesso!');
    }
}
