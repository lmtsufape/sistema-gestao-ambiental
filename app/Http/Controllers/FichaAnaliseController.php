<?php

namespace App\Http\Controllers;

use App\Http\Requests\FichaAnaliseRequest;
use App\Models\FichaAnalise;
use App\Models\FotoFichaAnalise;
use App\Models\SolicitacaoPoda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FichaAnaliseController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\SolicitacaoPoda $solicitacao
     * @param  \App\Http\Requests\FichaAnaliseRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoPoda $solicitacao, FichaAnaliseRequest $request)
    {
        $ficha = new FichaAnalise();
        $data = $request->validated();
        $ficha->solicitacao_poda_id = $solicitacao->id;
        $ficha->fill($data);
        $ficha->save();
        for ($i = 0; $i < count($data['imagem']); $i++) {
            $foto_ficha = new FotoFichaAnalise();
            $foto_ficha->ficha_analise_id = $ficha->id;
            $foto_ficha->comentario = $data['comentario'][$i] ?? "";
            $nomeImg = $data['imagem'][$i]->getClientOriginalName();
            $path = 'fichas/' .$ficha->id .'/imagens'.'/' ;
            Storage::putFileAs('public/' . $path, $data['imagem'][$i], $nomeImg);
            $foto_ficha->caminho = $path . $nomeImg;
            $foto_ficha->save();
        }
        return view('solicitacoes.podas.edit', ['solicitacao' => $solicitacao])->with('success', 'Ficha de análise criada com sucesso');
    }

    public function show(FichaAnalise $ficha)
    {
        return view('solicitacoes.podas.fichas.show', ['ficha' => $ficha]);
    }
}
