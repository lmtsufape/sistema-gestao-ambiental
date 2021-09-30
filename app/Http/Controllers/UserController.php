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
        $users = User::where('role', '!=', User::ROLE_ENUM['secretario'])->orderBy('name')->get();
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
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('isSecretario', User::class);
        $request->validated();
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
        //
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
            'name'          => ['required', 'string', 'max:255'],
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

        $user->name     = $input['name'];
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
}
