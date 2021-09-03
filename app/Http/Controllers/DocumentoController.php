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
        $data = $request->validated();
        $documento = new Documento();
        $documento->nome = $data["nome"];

        $caminho_licencas = "documentos/licencas/";
        $documento_nome = $data["documento_modelo"]->getClientOriginalName();
        Storage::putFileAs('public/' . $caminho_licencas, $data["documento_modelo"], $documento_nome);

        $documento->documento_modelo = $caminho_licencas . $data["documento_modelo"]->getClientOriginalName();
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
        $data = $request->validated();
        $documento = Documento::find($id);

        $caminho_licencas = "documentos/licencas/";
        $documento_nome = $data["documento_modelo"]->getClientOriginalName();
        Storage::delete('public/' . $documento->documento_modelo);
        Storage::putFileAs('public/' . $caminho_licencas, $data["documento_modelo"], $documento_nome);

        $documento->documento_modelo = $caminho_licencas . $data["documento_modelo"]->getClientOriginalName();
        $documento->save();

        return redirect(route('documentos.index'))->with(['success' => 'Documento editado com sucesso!']);
    }

    public function destroy($id)
    {
        $documento = Documento::find($id);
        Storage::delete('public/' . $documento->documento_modelo);
        $documento->delete();

        return redirect(route('documentos.index'))->with(['success' => 'Documento deletado com sucesso!']);
    }
}
