<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Models\Noticia;

class WelcomeController extends Controller
{
    public function index()
    {
        $noticias = Noticia::where([['destaque', true], ['publicada', true]])->orderBy('created_at', 'DESC')->get();
        $empresas = Empresa::all();

        return view('welcome', compact('noticias', 'empresas'));
    }
}
