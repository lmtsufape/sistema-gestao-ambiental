<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificacaoRequest;
use App\Models\Empresa;
use App\Models\FotoNotificacao;
use App\Models\Notificacao;
use App\Models\User;
use App\Notifications\NotificacaoCriadaNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class NotificacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Empresa $empresa
     *
     * @return View
     */
    public function index(Empresa $empresa)
    {
        $user = auth()->user();
        switch ($user->role) {
            case User::ROLE_ENUM['requerente']:
                $this->authorize('view', $empresa);
                $notificacoes = Notificacao::where('empresa_id', $empresa->id)->orderBy('created_at', 'DESC')->paginate(8);
                return view('notificacao.index', compact('notificacoes', 'empresa'));
                break;
            case User::ROLE_ENUM['analista']:
                $notificacoes = Notificacao::where('empresa_id', $empresa->id)->orderBy('created_at', 'DESC')->paginate(8);
                $this->authorize('isSecretarioOrAnalista', User::class);

                return view('notificacao.index', ['empresa' => $empresa, 'notificacoes' => $notificacoes]);
                break;
            case User::ROLE_ENUM['secretario']:
                $notificacoes = Notificacao::where('empresa_id', $empresa->id)->orderBy('created_at', 'DESC')->paginate(8);
                $this->authorize('isSecretarioOrAnalista', User::class);

                return view('notificacao.index', ['empresa' => $empresa, 'notificacoes' => $notificacoes]);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Empresa $empresa
     *
     * @return View
     */
    public function create(Empresa $empresa)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);

        return view('notificacao.create')->with('empresa', $empresa);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NotificacaoRequest $request
     * @param Empresa $empresa
     *
     * @return View
     */
    public function store(NotificacaoRequest $request, Empresa $empresa)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $notificacao = new Notificacao();
        $data = $request->validated();
        $notificacao->fill($data);
        $notificacao->empresa_id = $empresa->id;
        $notificacao->autor_id = auth()->user()->id;
        $notificacao->save();
        if (array_key_exists('imagem', $data)) {
            $count = count($data['imagem']);
            for ($i = 0; $i < $count; $i++) {
                $foto_notificacao = new FotoNotificacao();
                $foto_notificacao->notificacao_id = $notificacao->id;
                $foto_notificacao->comentario = $data['comentario'][$i] ?? '';
                $foto_notificacao->caminho = $data['imagem'][$i]->store("notificacoes/{$notificacao->id}");
                $foto_notificacao->save();
            }
        }
        Notification::send($empresa->user, new NotificacaoCriadaNotification($notificacao, $empresa));

        return redirect(route('empresas.notificacoes.index', ['empresa' => $empresa]))->with('success', 'Notificação criada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param Notificacao $notificacao
     * @return View
     */
    public function show(Notificacao $notificacao)
    {   
        if (! $notificacao->visto && auth()->user()->id == $notificacao->empresa->user->id) {
            $notificacao->visto = true;
            $notificacao->update();
        }

        return view('notificacao.show', ['notificacao' => $notificacao]);
    }

    public function foto(Notificacao $notificacao, FotoNotificacao $foto)
    {
        $this->authorize('view', $notificacao);

        return Storage::download($foto->caminho);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacao $notificacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NotificacaoRequest $request
     * @param Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacao $notificacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacao $notificacao)
    {
        //
    }

    public function get(Request $request)
    {
        $notificacao = Notificacao::find($request->notificacao_id);
        $notificacaoInfo = [
            'id' => $notificacao->id,
            'texto' => $notificacao->texto,
        ];

        return response()->json($notificacaoInfo);
    }

    
}
