<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Noticia;
use App\Models\Requerimento;

class WelcomeController extends Controller
{
    public function index()
    {
        $noticias = Noticia::where([['destaque', true], ['publicada', true]])->orderBy('created_at', 'DESC')->get();
        $empresas = Empresa::whereRelation('requerimentos', 'status' , "!=", Requerimento::STATUS_ENUM['cancelada'])
        ->whereRelation('requerimentos', 'cancelada' , "=", false)
        ->orderBy('nome')
        ->get()->map
        ->only(['id', 'nome', 'cpf_cnpj']);

        return view('welcome', compact('noticias', 'empresas'));
    }
}