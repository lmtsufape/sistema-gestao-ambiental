<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentoRequest;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Licenca;

class DocumentoController extends Controller
{
    public function index()
    {
        $this->authorize('isSecretario', User::class);
        $documentos = Documento::orderBy('nome')->paginate(25);
        return view('documento.index', compact('documentos'));
    }

    public function create()
    {
        $this->authorize('isSecretario', User::class);
        return view('documento.create');
    }

    public function store(DocumentoRequest $request)
    {
        $this->authorize('isSecretario', User::class);
        $documento = new Documento();
        $documento->setAtributes($request);

        if ($request->file('documento_modelo') != null) {
            $documento->salvarDocumento($request->file('documento_modelo'));
        }

        $documento->save();

        return redirect(route('documentos.index'))->with(['success' => 'Documento cadastrado com sucesso!']);
    }

    public function show($id)
    {
        //$this->authorize('isSecretario', User::class);
        $documento = Documento::find($id);

        if ($documento)
            return Storage::disk()->exists('public/' . $documento->documento_modelo) ? response()->file("storage/" . $documento->documento_modelo) : abort(404);
    }

    public function edit($id)
    {
        $this->authorize('isSecretario', User::class);
        $documento = Documento::find($id);

        return view('documento.edit', compact("documento"));
    }

    public function update(DocumentoRequest $request, $id)
    {
        $this->authorize('isSecretario', User::class);
        $documento = Documento::find($id);
        $documento->setAtributes($request);
        
        if ($request->file('documento_modelo') != null) {
            $documento->salvarDocumento($request->file('documento_modelo'));
        }

        $documento->update();

        return redirect(route('documentos.index'))->with(['success' => 'Documento editado com sucesso!']);
    }

    public function destroy($id)
    {
        $this->authorize('isSecretario', User::class);
        $documento = Documento::find($id);
        if ($documento->existemRequerimentos()) {
            return redirect()->back()->withErrors(['error' => 'Existem requerimentos que utilizam este documento, logo o mesmo não pode ser deletado.']);
        }
        
        $documento->deletar();

        return redirect(route('documentos.index'))->with(['success' => 'Documento deletado com sucesso!']);
    }

    public function documentosPadrao(Request $request)
    {
        $documentos = Documento::orderBy('nome')->get();
        $json = $this->gerarJson($request, $documentos);
        
        return response()->json($json);
    }

    private function gerarJson(Request $request, $documentos) 
    {
        $docs = collect();
        switch ($request->licenca_enum) {
            case Licenca::TIPO_ENUM['previa']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_previa,
                    ]);
                }
                break;
            case Licenca::TIPO_ENUM['instalacao']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_instalacao,
                    ]);
                }
                break;
            case Licenca::TIPO_ENUM['operacao']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_operacao,
                    ]);
                }
                break;
            case Licenca::TIPO_ENUM['simplificada']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_simplificada,
                    ]);
                }
                break;
            case Licenca::TIPO_ENUM['autorizacao_ambiental']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_autorizacao_ambiental,
                    ]);
                }
                break;
            case Licenca::TIPO_ENUM['regularizacao']:
                foreach ($documentos as $doc) {
                    $docs->push([
                        'id' => $doc->id,
                        'padrao' => $doc->padrao_regularizacao,
                    ]);
                }
                break;
        }
        return $docs;
    }
}
