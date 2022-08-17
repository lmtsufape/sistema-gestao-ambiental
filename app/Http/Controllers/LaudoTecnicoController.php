<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaudoTecnicoRequest;
use App\Models\FotoLaudoTecnico;
use App\Models\LaudoTecnico;
use App\Models\SolicitacaoPoda;
use Illuminate\Support\Facades\Storage;

class LaudoTecnicoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\SolicitacaoPoda  $solicitacao
     * @param  \App\Http\Requests\LaudoTecnicoRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoPoda $solicitacao, LaudoTecnicoRequest $request)
    {
        $laudo = new LaudoTecnico();
        $data = $request->validated();
        $laudo->solicitacao_poda_id = $solicitacao->id;
        $laudo->fill($data);
        $laudo->save();
        for ($i = 0; $i < count($data['imagem']); $i++) {
            $foto_laudo = new FotoLaudoTecnico();
            $foto_laudo->laudo_tecnico_id = $laudo->id;
            $foto_laudo->comentario = $data['comentario'][$i] ?? '';
            $foto_laudo->caminho = $data['imagem'][$i]->store("laudos/{$laudo->id}/imagens");
            $foto_laudo->save();
        }

        return view('solicitacoes.podas.edit', ['solicitacao' => $solicitacao])->with('success', 'Laudo tecnico criado com sucesso');
    }

    public function show(LaudoTecnico $laudo)
    {
        return view('solicitacoes.podas.laudos.show', ['laudo' => $laudo]);
    }

    public function foto(LaudoTecnico $laudo, FotoLaudoTecnico $foto)
    {
        $this->authorize('isAnalistaPodaOrSecretario', User::class);

        return Storage::download($foto->caminho);
    }
}
