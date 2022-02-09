<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;

class WelcomeController extends Controller
{
    public function index() 
    {
        $noticias = Noticia::where([['destaque', true], ['publicada', true]])->get();
        
        return view('welcome', compact('noticias'));
    }
}
