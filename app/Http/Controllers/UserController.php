<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\TipoAnalista;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isSecretario', User::class);
        $users = User::where('role', '!=', User::ROLE_ENUM['secretario'])->orderBy('name')->paginate(20);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isSecretario', User::class);
        $tipos = TipoAnalista::all();
        return view('user.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isSecretario', User::class);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'tipos_analista' => 'required',
            'tipos_analista.*' => 'required',
        ]);

        $user = new User();
        $user->setAtributes($request);
        $user->role = User::ROLE_ENUM['analista'];
        $user->email_verified_at = now();
        $user->save();
        foreach($request->tipos_analista as $tipo_id){
            $user->tipo_analista()->attach(TipoAnalista::find($tipo_id));
        }
        return redirect(route('usuarios.index'))->with(['success' => 'Analista cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('isSecretario', User::class);
        $usuario = User::find($id);
        $tipos = TipoAnalista::all();
        return view('user.edit', compact('tipos', 'usuario'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);
        $usuario = User::find($id);
        $input = $request->all();

        if($usuario->role == User::ROLE_ENUM['analista']){
            $request->validate([
                'tipos_analista' => 'required',
                'tipos_analista.*' => 'required',
            ]);
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email','max:255'],
        ]);

        if ($input['email'] != $usuario->email) {
            $userCheckEmail = User::where('email', $input['email'])->first();
            if ($userCheckEmail != null) {
                return redirect()->back()->withErrors(['email' => 'Esse email já está sendo utilizado.'])->withInput($validated);
            }
        }

        $usuario->setAtributes($request);
        $usuario->update();

        if($request->tipos_analista != null){
            $analista_tipos =  collect();
            foreach($usuario->tipo_analista as $tipo){
                if(!array_key_exists($tipo->pivot->tipo_analista_id, $request->tipos_analista)){
                    $tipo->pivot->delete();
                }else{
                    $analista_tipos->push($tipo->pivot->tipo_analista_id);
                }
            }
            
            foreach($request->tipos_analista as $tipo_id){
                if(!$analista_tipos->contains($tipo_id)){
                    $usuario->tipo_analista()->attach(TipoAnalista::find($tipo_id));
                }
            }
        }
        
        return redirect(route('usuarios.index'))->with(['success' => 'Usuário editado com sucesso!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $input = $request->all();

        $validated = $request->validate([
            'email'         => ['required', 'string', 'email','max:255'],
            'password_atual'=> ['nullable','string','min:8'],
        ]);

        if ($input['email'] != $user->email) {
            $userCheckEmail = User::where('email', $input['email'])->first();
            if ($userCheckEmail != null) {
                return redirect()->back()->withErrors(['email' => 'Esse email já está sendo utilizado.'])->withInput($validated);
            }
        }

        if ($input['password_atual'] != null || $input['password'] != null || $input['password_confirmation'] != null) {
            if (!Hash::check($input['password_atual'], $user->password)) {
                return redirect()->back()->withErrors(['password_atual' => 'Senha incorreta.'])->withInput($validated);
            }
            if ($input['password'] == null) {
                return redirect()->back()->withErrors(['password' => 'Informe uma nova senha.'])->withInput($validated);
            }
            if ($input['password_confirmation'] == null) {
                return redirect()->back()->withErrors(['password_confirmation' => 'Informe a confirmação da senha.'])->withInput($validated);
            }
            if ($input['password_confirmation'] != null && $input['password_confirmation'] != $input['password']) {
                return redirect()->back()->withErrors(['password' => 'As senhas não correspondem.'])->withInput($validated);
            }
        }

        $user->email    = $input['email'];
        if ($input['password_atual'] != null || $input['password'] != null || $input['password_confirmation'] != null) {
            $user->forceFill([
                'password' => Hash::make($input['password']),
            ])->save();
        }
        $user->update();

        return redirect(route('perfil'))->with(['success' => 'Dados salvos com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isSecretario', User::class);
        $user = User::find($id);
        foreach($user->tipo_analista()->get() as $tipo){
            $tipo->pivot->delete();
        }
        $user->delete();

        return redirect(route('usuarios.index'))->with(['success' => 'Analista deletado com sucesso!']);
    }

    /**
     * Retorna para a view de perfil do usuário atual.
     *
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {
        return view('user.perfil');
    }

    /**
     * Retorna para a view de informações de login do usuário atual.
     *
     * @return \Illuminate\Http\Response
     */
    public function infoLogin()
    {
        return view('user.login');
    }

    /**
     * Salva os dados básicos do usuário.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function atualizarDadosBasicos(Request $request)
    {
        $user = auth()->user();
        $requerente = $user->requerente;
        if($requerente != null){
            $telefone = $requerente->telefone;

            $request->validate([
                'nome_de_exibição'          => ['required', 'string', 'min:10', 'max:255'],
                'cpf'                       => ['required', 'string', 'cpf'],
                'telefone'                  => ['required', 'string', 'celular_com_ddd', 'max:255'],
                'rg'                        => ['required', 'string', 'max:255'],
                'orgão_emissor'             => ['required', 'string', 'max:255'],
                'foto_de_perfil'            => ['nullable', 'file',   'mimes:jpg,png', 'max:2048'],
            ], [
                'cpf.cpf'                   => 'O campo CPF não é um CPF válido.',
                'telefone.celular_com_ddd'  => 'O campo contato não é um contato com DDD válido.',
            ]);
            $requerente->cpf = $request->cpf;
            $telefone->numero = $request->telefone;
            $requerente->rg = $request->rg;
            $requerente->orgao_emissor = $request->input('orgão_emissor');
            $requerente->update();
            $telefone->update();
        }else{
            $request->validate([
                'nome_de_exibição'          => ['required', 'string', 'min:10', 'max:255'],
                'foto_de_perfil'            => ['nullable', 'file',   'mimes:jpg,png', 'max:2048'],
            ]);
        }
        
        $user->name = $request->input('nome_de_exibição');
        $user->salvarFoto($request);
        $user->update();
;

        return redirect(route('perfil'))->with(['success_dados_basicos' => 'Dados básicos atualizados com sucesso!']);
    }

    /**
     * Atualiza o endereço do requerente.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function atualizarEndereco(Request $request) 
    {
        $user = auth()->user();
        $endereco = $user->requerente->endereco;

        $request->validate([
            'cep'                       => ['required', 'string', 'max:255'],
            'bairro'                    => ['required', 'string', 'max:255'],
            'rua'                       => ['required', 'string', 'max:255'],
            'número'                    => ['required', 'string', 'max:255'],
            'cidade'                    => ['required', 'string', 'max:255'],
            'uf'                        => ['required', 'string', 'max:255'],
            'complemento'               => ['nullable', 'string', 'max:255'],
        ]);

        $endereco->setAtributes($request->all());
        $endereco->save();

        return redirect(route('perfil'))->with(['success_dados_basicos' => 'Endereço atualizado com sucesso!']);
    }
}
