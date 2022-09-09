<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class UsuariosIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $users = User::where('role', '!=', User::ROLE_ENUM['secretario'])
            ->where(function(Builder $qry){
                $qry->where('name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('email', 'ilike', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(20);
        return view('livewire.usuarios-index', ['users' => $users]);
    }

    public function updatingSearch()
    {
        $this->resetPage();

    }
}
