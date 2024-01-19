<?php

namespace App\Http\Controllers;

use App\Models\Telefone;
use App\Models\Endereco;
use App\Models\Feirante;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\User;

class FeiranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('isAnalista', User::class);

        $buscar = $request->input('buscar');

        if ($buscar != null) {
            $feirante = Feirante::where('nome', 'ILIKE', "%{$buscar}%")->orWhere('cpf', 'ILIKE', "%{$buscar}%")->get();
        } else {
            $feirante = Feirante::all()->sortBy('nome');
        }

        return view('feirantes.index', compact('feirante', 'buscar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isAnalista', User::class);
        return view('feirantes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAnalista', User::class);
        $input = $request->all();

        $feirante = new Feirante();
        $endereco_residencia = new Endereco();
        $endereco_comercio = new Endereco();
        $telefone = new Telefone();

        // Modificando os atributos nulos endereço residencial
        $input['cep'] = $input['cep'] ?? '55299-899';
        $input['numero'] = $input['numero'] ?? 's/n';
        $input['bairro'] = $input['bairro'] ?? $input['rua'];
        $input['complemento'] = $input['complemento'] ?? '';

        // Modificando os atributos nulos endereço do comércio
        $input['cep_comercio'] = $input['cep_comercio'] ?? '55299-899';
        $input['numero_comercio'] = $input['numero_comercio'] ?? 's/n';
        $input['bairro_comercio'] = $input['bairro_comercio'] ?? $input['rua'];
        $input['complemento_comercio'] = $input['complemento_comercio'] ?? '';

        $endereco_residencia->setAtributes($input);
        $endereco_residencia->save();

        $endereco_comercio->setAtributesComercio($input);
        $endereco_comercio->save();

        $telefone->setNumero($input['celular']);
        $telefone->save();

        $feirante->setAtributes($input);
        $feirante->endereco_residencia_id = $endereco_residencia->id;
        $feirante->endereco_comercio_id = $endereco_comercio->id;
        $feirante->telefone_id = $telefone->id;
        $feirante->save();

        return redirect(route('feirantes.index'))->with(['success' => 'Feirante cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($feirante_id)
    {
        $this->authorize('isAnalista', User::class);

        $feirante = Feirante::findOrFail($feirante_id);
        $endereco_residencia = Endereco::findOrFail($feirante->endereco_residencia_id);
        $endereco_comercio = Endereco::findOrFail($feirante->endereco_comercio_id);
        $telefone = Telefone::findOrFail($feirante->telefone_id);

        return view('feirantes.show', compact('feirante', 'endereco_residencia', 'endereco_comercio', 'telefone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($feirante_id)
    {
        $this->authorize('isAnalista', User::class);
        $feirante = Feirante::findOrFail($feirante_id);
        $endereco_residencia = Endereco::findOrFail($feirante->endereco_residencia_id);
        $endereco_comercio = Endereco::findOrFail($feirante->endereco_comercio_id);
        $telefone = Telefone::findOrFail($feirante->telefone_id);

        return view('feirantes.edit', compact('feirante', 'endereco_residencia', 'endereco_comercio', 'telefone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $feirante_id)
    {
        $this->authorize('isAnalista', User::class);

        $input = $request->all();

        $feirante = Feirante::findOrFail($feirante_id);
        $endereco_residencia = Endereco::findOrFail($feirante->endereco_residencia_id);
        $endereco_comercio = Endereco::findOrFail($feirante->endereco_comercio_id);
        $telefone = Telefone::findOrFail($feirante->telefone_id);

        $feirante->setAtributes($input);
        $endereco_residencia->setAtributes($input);
        $endereco_comercio->setAtributes($input);
        $telefone->setNumero($input['celular']);

        $endereco_residencia->update();
        $endereco_comercio->update();
        $telefone->update();

        $feirante->update();

        return redirect(route('feirantes.index'))->with(['success' => 'Feirante editado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($feirante_id)
    {
        try {
            $this->authorize('isAnalista', User::class);

            $feirante = Feirante::find($feirante_id);
            if (!$feirante) {
                return redirect(route('feirantes.index'))->with(['error' => 'Feirante não encontrado']);
            }

            $endereco_residencia = Endereco::findOrFail($feirante->endereco_residencia_id);
            $endereco_comercio = Endereco::findOrFail($feirante->endereco_comercio_id);
            $telefone = Telefone::findOrFail($feirante->telefone_id);

            // Excluir os registros
            $feirante->delete();
            $endereco_residencia->delete();
            $endereco_comercio->delete();
            $telefone->delete();

            return redirect(route('feirantes.index'))->with(['success' => 'Feirante excluído com sucesso!']);
        } catch (\Exception $e) {
            return redirect(route('feirantes.index'))->with(['error' => 'Não é possível excluir o feirante']);
        }
    }

    public function comprovante_cadastro($feirante_id)
    {
        $this->authorize('isAnalista', User::class);

        $feirante = Feirante::findOrFail($feirante_id);

        $endereco_comercio = Endereco::findOrFail($feirante->endereco_comercio_id);

        $data_cadastro = $feirante->created_at->format('d/m/Y');

        $pdf = \Barryvdh\DomPDF\Facade::loadView('pdf.comprovante_cadastro_feirante', ['feirante' => $feirante,
                                                'data_cadastro' => $data_cadastro, 'endereco_comercio' => $endereco_comercio]);

        return $pdf->setPaper('a4')->stream('comprovante_cadastro_feirante.pdf');
    }
}
