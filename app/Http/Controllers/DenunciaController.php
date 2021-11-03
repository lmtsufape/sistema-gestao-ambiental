<?php

namespace App\Http\Controllers;

use App\Http\Requests\DenunciaRequest;
use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\FotoDenuncia;
use App\Models\VideoDenuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class DenunciaController extends Controller
{
    public function index()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);

        $denuncias_registradas = collect();
        $denuncias_aprovadas = collect();
        $denuncias_arquivadas = collect();
        $user = auth()->user();
        switch ($user->role) {
            case User::ROLE_ENUM['secretario']:
                $denuncias_registradas = Denuncia::where('aprovacao', '1')->orderBy('empresa_id', 'ASC')->get();
                $denuncias_aprovadas   = Denuncia::where('aprovacao', '2')->orderBy('empresa_id', 'ASC')->get();
                $denuncias_arquivadas  = Denuncia::where('aprovacao', '3')->orderBy('empresa_id', 'ASC')->get();
                break;
            case User::ROLE_ENUM['analista']:
                $denuncias_registradas = Denuncia::where([['aprovacao', '1'], ['analista_id', $user->id]])->orderBy('empresa_id', 'ASC')->get();
                $denuncias_aprovadas   = Denuncia::where([['aprovacao', '2'], ['analista_id', $user->id]])->orderBy('empresa_id', 'ASC')->get();
                $denuncias_arquivadas  = Denuncia::where([['aprovacao', '3'], ['analista_id', $user->id]])->orderBy('empresa_id', 'ASC')->get();
                break;
        }

        $denuncias = $denuncias_registradas->concat($denuncias_aprovadas)->concat($denuncias_arquivadas);
        $analistas = User::where('role', User::ROLE_ENUM['analista'])->get();

        return view('denuncia.index', compact('denuncias_registradas', 'denuncias_aprovadas', 'denuncias_arquivadas', 'denuncias', 'analistas'));
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
        $protocolo = $this->gerarProtocolo($data['texto']);
        $denuncia->protocolo = $protocolo;
        $denuncia->save();

        if (array_key_exists("imagem", $data))
            for ($i = 0; $i < count($data['imagem']); $i++) {
                $foto_denuncia = new FotoDenuncia();
                $foto_denuncia->denuncia_id = $denuncia->id;
                $foto_denuncia->comentario = $data['comentario'][$i] ?? "";

                $nomeImg = $data['imagem'][$i]->getClientOriginalName();
                $path = 'denuncias/' . $denuncia->id .'/imagens'.'/';
                Storage::putFileAs('public/' . $path, $data['imagem'][$i], $nomeImg);
                $foto_denuncia->caminho = $path . $nomeImg;
                $foto_denuncia->save();
            }

        if (array_key_exists("video", $data)){
            for ($i = 0; $i < count($data['video']); $i++) {
                $video_denuncia = new VideoDenuncia();
                $video_denuncia->denuncia_id = $denuncia->id;
                $video_denuncia->comentario = $data['comentario'][$i] ?? "";

                $nomeVideo = $data['video'][$i]->getClientOriginalName();
                $path = 'denuncias/' . $denuncia->id .'/videos'.'/';
                Storage::putFileAs('public/' . $path, $data['video'][$i], $nomeVideo);
                $video_denuncia->caminho = $path . $nomeVideo;
                $video_denuncia->save();
            }
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
        $denuncia = Denuncia::find($request->denunciaId);
        $this->authorize('isSecretarioOrAnalista', User::class);

        if ($request->aprovar == "true") {
            $denuncia->aprovacao = Denuncia::APROVACAO_ENUM['aprovada'];
            $msg = 'Denuncia aprovada com sucesso!';

        } else if ($request->aprovar == "false") {
            $denuncia->aprovacao = Denuncia::APROVACAO_ENUM['arquivada'];
            $msg = 'Denuncia arquivada com sucesso!';

        }
        $denuncia->update();

        return redirect()->back()->with(['success' => $msg]);
    }

    /**
     * Atribuir uma denúncia a um analaista.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function atribuirAnalistaDenuncia(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $request->validate([
            'denuncia_id_analista' => 'required',
            'analista'             => 'required',
        ]);

        $denuncia = Denuncia::find($request->denuncia_id_analista);
        $denuncia->analista_id = $request->analista;
        $denuncia->update();

        return redirect(route('denuncias.index'))->with(['success' => 'Denúncia atribuida com sucesso ao analista.']);
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

    private function gerarProtocolo($texto)
    {
        $protocolo = null;
        do {
            $protocolo = substr(str_shuffle(Hash::make($texto)), 0, 20);
            $check = Denuncia::where('protocolo', $protocolo)->first();
        } while($check != null);
        return $protocolo;
    }

    public function get(Request $request) {
        $denuncia = Denuncia::find($request->denuncia_id);
        $denunciaInfo = [
            'id' => $denuncia->id,
            'texto' => $denuncia->texto,
        ];
        return response()->json($denunciaInfo);
    }
}
