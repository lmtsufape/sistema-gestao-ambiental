<?php

namespace App\Http\Livewire;

use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithPagination;

class EmpresasIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        return view('livewire.empresas-index', ['empresas' => Empresa::where('nome', 'ilike', '%' . $this->search . '%')->paginate(20)]);
    }

    public function updatingSearch()
    {
        $this->resetPage();

    }
}
