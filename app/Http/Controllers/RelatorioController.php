<?php

namespace App\Http\Controllers;

use App\Http\Requests\RelatorioRequest;
use App\Models\FotosRelatorio;
use App\Models\Relatorio;
use App\Models\Requerimento;
use App\Models\Visita;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $visita = Visita::find($id);

        return view('relatorio.create', compact('visita'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RelatorioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RelatorioRequest $request)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $visita = Visita::find($request->visita);
        $relatorio = new Relatorio();
        $fotos_relatorio = new FotosRelatorio();
        $relatorio->setAtributes($request);
    
        if ($request->has('arquivoFile') != null) {
            $relatorio->salvarArquivo($request['arquivoFile'], $visita->id, $relatorio);
        }
        $relatorio->save();

        if ($request->has('imagem') != null) {
            $fotos_relatorio->salvarImagem($request['imagem'], $visita->id, $fotos_relatorio);
            $fotos_relatorio->save();
        }

        if ($visita->requerimento != null) {
            $requerimento = $visita->requerimento;
            $requerimento->status = Requerimento::STATUS_ENUM['visita_realizada'];
            $requerimento->update();
        }

        $filtro = auth()->user()->getUserType();

        return redirect(route('visitas.index', [$filtro, 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Relatório salvo com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);
        $fotos_relatorio = FotosRelatorio::where('relatorio_id', $relatorio->id);
        $caminho = $fotos_relatorio->first()->caminho ?? null;

        return view('relatorio.show', compact('relatorio', 'caminho'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);

        return view('relatorio.edit', compact('relatorio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RelatorioRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RelatorioRequest $request)
    {   
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($request->visita);
        if($fotos_relatorio = FotosRelatorio::where('relatorio_id', $request->visita)->first() == null){
            $fotos_relatorio = new FotosRelatorio();
        }else{
            $fotos_relatorio = FotosRelatorio::where('relatorio_id', $request->visita)->first();
        }

        if ($relatorio->aprovacao == Relatorio::APROVACAO_ENUM['aprovado']) {
            return redirect()->back()->with(['error' => 'Este relatório não pode ser editado!']);
        }
        $relatorio->setAtributes($request);
        $relatorio->motivo_edicao = null;

        if ($request->has('arquivoFile') != null) {
            $relatorio->salvarArquivo($request['arquivoFile'], $request->visita, $relatorio);
        }
        $relatorio->update();
        
        if ($request->has('imagem') != null) {
            $fotos_relatorio->salvarImagem($request['imagem'], $request->visita, $fotos_relatorio);
            $fotos_relatorio->update();
        }
        
        $filtro = auth()->user()->getUserType();

        return redirect(route('visitas.index', [$filtro, 'ordenacao' => 'data_marcada', 'ordem' => 'DESC']))->with(['success' => 'Relatório atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resultado(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);
        $relatorio = Relatorio::find($id);
        $resultado = (bool) $request->aprovacao;
        $relatorio->motivo_edicao = $request->motivo;

        $msg = '';
        if ($resultado) {
            $relatorio->aprovacao = Relatorio::APROVACAO_ENUM['aprovado'];
            $msg = 'Relatório aprovado com sucesso!';
        } else {
            $relatorio->aprovacao = Relatorio::APROVACAO_ENUM['reprovado'];
            $msg = 'Relatório enviado para revisão do analista.';
        }

        $relatorio->update();

        return redirect(route('relatorios.show', ['relatorio' => $relatorio->id]))->with(['success' => $msg]);
    }

    public function downloadArquivo($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $relatorio = Relatorio::find($id);
        $arquivo = $relatorio->arquivo;
        $path = storage_path('app/' . $arquivo);

        return response()->download($path);
    }

    public function downloadImagem($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $fotos = FotosRelatorio::where('relatorio_id', $id)->first();
        $path = $fotos->caminho;
        return response()->download($path);
    }

    public function recuperarRelatorios(Requerimento $requerimento)
    {
        $empresa = $requerimento->empresa;
        $requerimentosIds = Requerimento::where('empresa_id', $empresa->id)->pluck('id');
        $visitas = Visita::whereIn('requerimento_id', $requerimentosIds)->get();
        $relatorios = Relatorio::whereIn('visita_id', $visitas->pluck('id'))->get();

        return view('relatorio.listar', compact('relatorios', 'visitas'));
    }


}
