<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaudoTecnicoRequest;
use App\Models\FotoLaudoTecnico;
use App\Models\LaudoTecnico;
use App\Models\SolicitacaoPoda;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // ⚠️ faltava esse import no seu arquivo
use Barryvdh\DomPDF\Facade as PDF;

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
        $count = count($data['imagem']);
        for ($i = 0; $i < $count; $i++) {
            $foto_laudo = new FotoLaudoTecnico();
            $foto_laudo->laudo_tecnico_id = $laudo->id;
            $foto_laudo->comentario = $data['comentario'][$i] ?? '';
            $foto_laudo->caminho = $data['imagem'][$i]->store("laudos/{$laudo->id}/imagens");
            $foto_laudo->save();
        }

        if ($request->has('licenca')) {
            $laudo->licenca = $data['licenca']->store("laudos/{$laudo->id}/");
        }

        if ($request->pdf) {
            $laudo->pdf = $data['pdf']->store("laudos/{$laudo->id}/");
        }

        $laudo->update();

        return redirect()->route('podas.edit', ['solicitacao' => $solicitacao])->with('success', 'Laudo tecnico criado com sucesso');
    }

    public function show(LaudoTecnico $laudo)
    {
        $atividades = LaudoTecnico::ATIVIDADE_ENUM;
        $rotulo = array_search($laudo->atividade, $atividades, true) ?: $laudo->atividade;
        return view('solicitacoes.podas.laudos.show', [
            'laudo'            => $laudo,
            'rotulo'  => $rotulo,
        ]);
    }

    public function pdf(LaudoTecnico $laudo)
    {
        return Storage::exists($laudo->pdf) ? Storage::download($laudo->pdf) : abort(404);
    }

    public function licenca(LaudoTecnico $laudo)
    {
        return Storage::exists($laudo->licenca) ? Storage::download($laudo->licenca) : abort(404);
    }

    public function foto(LaudoTecnico $laudo, FotoLaudoTecnico $foto)
    {
        $this->authorize('isAnalistaPodaOrSecretario', User::class);

        return Storage::download($foto->caminho);
    }
    public function exportarPdf(LaudoTecnico $laudo)
    {

        $atividades = LaudoTecnico::ATIVIDADE_ENUM;
        $rotulo = array_search($laudo->atividade, $atividades, true) ?: $laudo->atividade;

        $solicitacao = $laudo->solicitacaoPoda()
            ->with(['requerente.user', 'endereco', 'telefone', 'fotos'])
            ->first();

        $imagensLaudo = $laudo->fotos->map(function ($foto) {
            $bin = Storage::get($foto->caminho);

            return [
                'src'        => 'data:image/jpeg;base64,' . base64_encode($bin),
                'comentario' => $foto->comentario,
            ];
        });

        $imagensSolicitacao = $solicitacao && $solicitacao->fotos
            ? $solicitacao->fotos->map(function ($foto) {
                $bin = Storage::get($foto->caminho);
                return [
                    'src'        => 'data:image/jpeg;base64,' . base64_encode($bin),
                    'comentario' => $foto->comentario,
                ];
            })
            : collect();

        PDF::setOptions([
            'isRemoteEnabled'      => false,
            'isHtml5ParserEnabled' => true,
            'dpi'                  => 96,
        ]);

        $pdf = PDF::loadView('solicitacoes.podas.laudos.pdf', [
            'laudo'               => $laudo,
            'rotulo'              => $rotulo,
            'solicitacao'         => $solicitacao,
            'imagensLaudo'        => $imagensLaudo,
            'imagensSolicitacao'  => $imagensSolicitacao,
        ])->setPaper('a4');

        return $pdf->download('laudo-tecnico-ambiental-' . $laudo->id . '.pdf');
    }
}
