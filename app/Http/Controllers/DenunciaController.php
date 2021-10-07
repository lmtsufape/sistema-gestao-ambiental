<?php

namespace App\Http\Controllers;

use App\Http\Requests\DenunciaRequest;
use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\FotoDenuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DenunciaController extends Controller
{
    public function index()
    {
        $denuncias_registradas = Denuncia::where('aprovacao', '1')->orderBy('empresa_id', 'ASC')->get();
        $denuncias_aprovadas   = Denuncia::where('aprovacao', '2')->orderBy('empresa_id', 'ASC')->get();
        $denuncias_arquivadas  = Denuncia::where('aprovacao', '3')->orderBy('empresa_id', 'ASC')->get();

        return view('denuncia.index', compact('denuncias_registradas', 'denuncias_aprovadas', 'denuncias_arquivadas'));
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
        $denuncia->denunciante = $data['denunciante'] ?? "";
        $denuncia->aprovacao = Denuncia::APROVACAO_ENUM["registrada"];
        $protocolo = Hash::make('texto');
        $denuncia->protocolo = $protocolo;
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

        return redirect()->back()->with(['success' => 'Denúncia cadastrada com sucesso!', 'protocolo' => $protocolo]);
    }

    public function edit()
    {
        return redirect()->route("denuncias.create");
    }

    public function update()
    {
        return redirect()->route("denuncias.create");
    }

    public function imagensDenuncia(Request $request)
    {
        $imagens = FotoDenuncia::where('denuncia_id', $request->id)->get();
        $caminhos = [];

        foreach ($imagens as $key) {
            array_push($caminhos, $key->caminho);
        }

        $data = array(
            'success'    => true,
            'table_data' => $caminhos,
        );
        echo json_encode($data);
    }

    public function avaliarDenuncia(Request $request)
    {
        if ($request->aprovar == "true") {
            $denuncia = Denuncia::find($request->denunciaId);
            $denuncia->aprovacao = 2;
            $denuncia->save();

            return redirect()->back()->with(['success' => 'Denuncia aprovada com sucesso!']);
        } else if ($request->aprovar == "false") {

            $denuncia = Denuncia::find($request->denunciaId);
            $denuncia->aprovacao = 3;
            $denuncia->save();

            return redirect()->back()->with(['success' => 'Denuncia arquivada com sucesso!']);
        }
    }

    public function statusDenuncia(Request $request)
    {
        $denuncia = Denuncia::where('protocolo', $request->protocolo)->first();
        if($denuncia == null){
            return redirect()->back()->with(['error' => 'A denúncia informada não se encontra no banco de registro de denúncias.']);
        }else{
            return view('denuncia.status', compact('denuncia'));
        }
    }

}
