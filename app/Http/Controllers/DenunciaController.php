<?php

namespace App\Http\Controllers;

use App\Http\Requests\DenunciaRequest;
use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\FotoDenuncia;
use Illuminate\Support\Facades\Storage;

class DenunciaController extends Controller
{
    public function index()
    {
        return redirect()->route("denuncias.create");
    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('denuncia.create', compact('empresas'));
    }

    public function store(DenunciaRequest $request)
    {
        $data = $request->validated();

        $denuncia = new Denuncia();
        $denuncia->texto = $data['texto'];
        $denuncia->empresa_id = strcmp($data['empresa_id'], "none") == 0 || empty($data['empresa_id']) ? null : $data['empresa_id'];
        $denuncia->empresa_nao_cadastrada = $data['empresa_nao_cadastrada'] ?? "";
        $denuncia->endereco = $data['endereco'] ?? "";
        $denuncia->crime_ambiental = $data['crime_ambiental'] ?? false;
        $denuncia->aprovacao = Denuncia::APROVACAO_ENUM["registrada"];
        $denuncia->save();

        if (array_key_exists("imagem", $data))
            for ($i = 0; $i < count($data['imagem']); $i++) {
                $foto_denuncia = new FotoDenuncia();
                $foto_denuncia->denuncia_id = $denuncia->id;
                $foto_denuncia->comentario = $data['comentario'][$i] ?? "";

                $nomeImg = $data['imagem'][$i]->getClientOriginalName();
                $path = 'denuncias/' . $denuncia->id . '/';
                Storage::putFileAs('public/' . $path, $data['imagem'][$i], $nomeImg);
                $foto_denuncia->caminho = $path . $nomeImg;
                $foto_denuncia->save();
            }

        return redirect()->back()->with(['success' => 'Denúncia cadastrada com sucesso!']);
    }

    public function edit()
    {
        return redirect()->route("denuncias.create");
    }

    public function update()
    {
        return redirect()->route("denuncias.create");
    }
}
