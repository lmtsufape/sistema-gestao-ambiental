<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentoRequest;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::all();
        return view('documento.index', compact('documentos'));
    }

    public function create()
    {
        return view('documento.create');
    }

    public function store(DocumentoRequest $request)
    {
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
        $documento = Documento::find($id);

        if ($documento)
            return Storage::disk()->exists('public/' . $documento->documento_modelo) ? response()->file("storage/" . $documento->documento_modelo) : abort(404);
    }

    public function edit($id)
    {
        $documento = Documento::find($id);

        return view('documento.edit', compact("documento"));
    }

    public function update(DocumentoRequest $request, $id)
    {
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
        $documento = Documento::find($id);
        if ($documento->existemRequerimentos()) {
            return redirect()->back()->withErrors(['error' => 'Existem requerimentos que utilizam desde documento, logo o mesmo não pode ser deletado.']);
        }
        
        $documento->deletar();

        return redirect(route('documentos.index'))->with(['success' => 'Documento deletado com sucesso!']);
    }
}
