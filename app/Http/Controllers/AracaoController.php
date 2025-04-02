<?php

namespace App\Http\Controllers;

use App\Models\Aracao;
use App\Http\Controllers\Controller;
use App\Models\FotoAracao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use Illuminate\Support\Facades\Storage;

class AracaoController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $query = Aracao::query();

        if ($request->filled('buscar') && $request->filled('filtro')) {
            $buscar = $request->input('buscar');
            $filtro = $request->input('filtro');


            $query->whereHas('beneficiario', function($q) use ($buscar, $filtro) {
                $q->where($filtro, 'ILIKE', "%{$buscar}%");
            });
        }

        $aracao = $query->get();

        return view('aracao.index', compact('aracao'));
    }

    public function create()
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $beneficiarios = Beneficiario::where('tipo_beneficiario', '=', Beneficiario::ROLE_ENUM['aracao'])->orWhere('tipo_beneficiario', '=', Beneficiario::ROLE_ENUM['ambos'])->get();

        return view('aracao.create', compact('beneficiarios'));
    }

    public function store(Request $request)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = new Aracao();
        $aracao->setAtributes($request);
        $aracao->save();

        return redirect()->route('aracao.index')->with('success', 'Aração cadastrada com sucesso!');
    }

    public function show($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::with('fotos')->findOrFail($id);

        return view('aracao.show', compact('aracao'));
    }

    public function edit($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);
        $beneficiarios = Beneficiario::where('tipo_beneficiario', '=', Beneficiario::ROLE_ENUM['aracao'])->orWhere('tipo_beneficiario', '=', Beneficiario::ROLE_ENUM['ambos'])->get();

        return view('aracao.edit', compact('aracao', 'beneficiarios'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);
        $aracao->setAtributes($request);
        $aracao->update();

        return redirect()->route('aracao.index')->with('success', 'Aração atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);

        $aracao = Aracao::find($id);
        $aracao->delete();

        return redirect()->route('aracao.index')->with('success', 'Aração excluída com sucesso!');
    }

    public function anexarFotos(Request $request, $id)
    {
        $this->authorize('isSecretarioOrBeneficiario', User::class);
        $request->validate([
            'foto_antes' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_depois' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'comentario_antes' => 'nullable|string|max:255',
            'comentario_depois' => 'nullable|string|max:255',
        ]);

        $aracao = Aracao::findOrFail($id);

        if ($request->hasFile('foto_antes') && $request->hasFile('foto_depois')) {
            foreach ($aracao->fotos as $foto) {
                Storage::delete($foto->caminho);
                $foto->delete();
            }

        }

        $fotos = [
            'antes' => $request->file('foto_antes'),
            'depois' => $request->file('foto_depois'),
        ];

        foreach ($fotos as $key => $foto) {
            $path = $foto->store("aracoes/{$id}/fotos");

            FotoAracao::create([
                'aracao_id' => $id,
                'caminho' => $path,
                'comentario' => $request->input("comentario_{$key}") ?? null,
            ]);
        }

        return back()->with('success', 'Fotos anexadas com sucesso!');
    }


    // public function gerarPedidosAracao(){
    //     $this->authorize('isSecretarioOrBeneficiario', User::class);

    //     $aracaos = Aracao::all();

    //     if (empty($aracao)) {
    //         return redirect()->route('aracao.index')->with('error', 'Não há solicitações de serviço para gerar pedidos!');
    //     } else {
    //         $pdf = PDF::loadView('aracao.PDF.pedidos_aracao', compact('aracaos'));
    //         $pdf->setOption('header-html', view('aracao.PDF.header')->render());
    //         return $pdf->download('pedidos_aracao.pdf');
    //     }
    // }
}
