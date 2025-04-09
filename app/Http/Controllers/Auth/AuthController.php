<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Certifique-se de importar o modelo User
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
        return view('register'); // Exibe a página de registro
    }

    /**
     * Processa o formulário de registro.
     */
    public function register(Request $request)
    {
        // Validação dos dados do formulário
        $validator = Validator::make($request->all(), [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefone' => ['required', 'string', 'max:20'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'string', 'in:masculino,feminino,outro'],
            'disability_type' => ['required', 'string', 'in:visual,auditiva,fisica,intelectual,nenhuma'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Se a validação falhar, redireciona com erros
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cria o usuário no banco de dados
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'phone' => $request->telefone,
            'birthdate' => $request->data_nascimento,
            'gender' => $request->sexo,
            'disability_type' => $request->disability_type,
            'password' => Hash::make($request->password),
        ]);

        // Autentica o usuário automaticamente após o cadastro
        Auth::login($user);

        // Redireciona para a página de sucesso após o cadastro
        return redirect()->route('sucesso')->with('success', 'Cadastro realizado com sucesso!');
    }

    /**
     * Mostra o formulário de login.
     */
    public function showLoginForm()
    {
        return view('login'); // Exibe a página de login
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
            return redirect()->route('postagem')->with('success', 'Login realizado com sucesso!');
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