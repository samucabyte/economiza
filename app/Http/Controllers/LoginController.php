<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Spent;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {


        return view('login');
    }
    public function loginAction(Request $r)
    {

        $email = $r->post('email');
        $pass = $r->post('password');

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($pass, $user->password)) {
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Login realizado com sucesso!');
        } else {
            return redirect()->route('login')->with('erro', 'E-mail e/ou senha estão incorretos');
        }
    }
    public function register()
    {

        return view('register');
    }
    public function registerAction(Request $r)
    {
        $data = $r->only([
            'name',
            'email',
            'password',
        ]);

        $rule = [
            'name' => 'required|string|min:4',
            'email' => 'required|email|unique:users,email', // Especificando a tabela e a coluna
            'password' => 'required|string|min:4', // Validação da senha (opcional)
        ];
        $validator = Validator::make($data, $rule);
        if ($validator->fails()) {
            return \redirect()->route('register')->withErrors($validator)->withInput();
        }
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password'])

            ]);  
        
        return redirect()->route('home');
    }
    public function loginReset()
    {

        return view('resetLogin');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
