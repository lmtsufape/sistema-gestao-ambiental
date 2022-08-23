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
        $search = preg_replace('/([0-9])/', '%$1', $this->search) . '%';
        $empresas = Empresa::where('nome', 'ilike', '%' . $this->search . '%')
            ->orWhere('cpf_cnpj', 'like', $search)
            ->orderBy('nome')
            ->paginate(20);
        return view('livewire.empresas-index', ['empresas' => $empresas]);
    }

    public function updatingSearch()
    {
        $this->resetPage();

    }
}
