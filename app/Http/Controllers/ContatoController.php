<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContatoMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ContatoController extends Controller
{
    public function contato() {
        return view('contato');
    }

    public function enviar(Request $request) {
        
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email'         => 'required|email',
            'mensagem'      => 'required|min:25|max:2000',
        ]);

        Mail::to(env('MAIL_CONTATO'))->send(new ContatoMail($request));

        return redirect(route('contato'))->with(['success' => 'Obrigado por entrar em contato, sua mensagem foi enviada com sucesso!']);
    }
}
