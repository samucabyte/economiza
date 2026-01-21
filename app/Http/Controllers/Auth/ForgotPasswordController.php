<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('resetLogin'); // formulário
    }

    public function sendResetLinkEmail(Request $request)
    {
        dd($request->all());
        // 1. validar email
        $request->validate([
            'email' => 'required|email'
        ]);

        // 2. Tentar enviar o link
        $status = Password::sendResetLink(
            $request->only('email') // só passa o email
        );
        

        // 3. Verificar resultado da operação
        if ($status === Password::RESET_LINK_SENT) {
            // SUCCESS — e-mail enviado
            return back()->with('success', __($status));
        }

        // 4. Erro — email não encontrado, ou outro problema
        return back()->withErrors(['email' => __($status)]);
    }
}
