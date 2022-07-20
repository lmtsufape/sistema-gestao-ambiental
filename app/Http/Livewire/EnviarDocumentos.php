<?php

namespace App\Http\Livewire;

use App\Models\Checklist;
use App\Models\Requerimento;
use App\Notifications\DocumentosEnviadosNotification;
use App\Rules\ArquivoEnviado;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\FileUploadConfiguration;
use Livewire\WithFileUploads;

class EnviarDocumentos extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $documentos;
    public $arquivos;
    public $status;
    public $requerimentoStatus;
    protected $validationAttributes = [];

    public function mount(Requerimento $requerimento)
    {
        $this->requerimento = $requerimento;
        $this->documentos = $this->requerimento->documentos()->withPivot('status', 'comentario')->get();
        $this->arquivos = $this->documentos->pluck('', 'id')->toArray();
        $this->regras = [];
        foreach ($this->documentos as $value) {
            $this->regras['arquivos.'.$value->id] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $this->validationAttributes['arquivos.'.$value->id] = $value->nome;
        }
        $this->status = Checklist::STATUS_ENUM;
        $this->requerimentoStatus = Requerimento::STATUS_ENUM;
    }

    public function updated($propertyName, $value)
    {
        $this->attributes();
        $id = explode('.', $propertyName)[1];
        $documento = $this->requerimento->documentos()->withPivot('status')->where('documento_id', $id)->first();
        if ($documento->pivot->status == Checklist::STATUS_ENUM['nao_enviado'] || $documento->status == \App\Models\Checklist::STATUS_ENUM['recusado'] || ($this->requerimento->status == $this->requerimentoStatus['documentos_requeridos'] || $documento->status == \App\Models\Checklist::STATUS_ENUM['enviado'])) {
            $this->withValidator(function (Validator $validator) {
                if ($validator->fails()) {

                    $this->dispatchBrowserEvent('swal:fire', [
                        'icon' => 'error',
                        'title' => 'Erro ao enviar o arquivo, verifique o campo inválido!'
                    ]);
                }
            })->validateOnly($propertyName, $this->regras);
            if($documento->caminho != null&& Storage::exists($documento->caminho)){
                Storage::delete($documento->caminho);
            }
            $this->requerimento->documentos()->updateExistingPivot($id, [
                'caminho' => $value->store("documentos/requerimentos/{$this->requerimento->id}"),
                'status' => Checklist::STATUS_ENUM['enviado'],
            ]);
        }
    }

    public function attributes()
    {
        foreach ($this->documentos as $value) {
            $this->validationAttributes['arquivos.'.$value->id] = $value->nome;
        }
    }

    private function rulesSubmit()
    {
        $rules = [];
        foreach ($this->documentos->pluck('id') as $key) {
            $rules['arquivos.'.$key] = [new ArquivoEnviado($this->requerimento, $key)];
        }
        return $rules;
    }

    public function submit()
    {
        $this->attributes();
        $this->withValidator(function (Validator $validator) {
            if ($validator->fails()) {
                $this->dispatchBrowserEvent('swal:fire', [
                    'icon' => 'error',
                    'title' => 'Erro ao enviar os arquivos, verifique os campos inválidos!'
                ]);
            }
        })->validate($this->rulesSubmit());
        $this->requerimento->status = Requerimento::STATUS_ENUM['documentos_enviados'];
        $this->requerimento->update();

        Notification::send($this->requerimento->analista, new DocumentosEnviadosNotification($this->requerimento, 'Documentos enviados'));

        return redirect(route('requerimentos.index', 'atuais'))->with(['success' => 'Documentação enviada com sucesso. Aguarde o resultado da avaliação dos documentos.']);

    }

    public function render()
    {
        return view('livewire.enviar-documentos');
    }

    protected function cleanupOldUploads()
    {
        if (FileUploadConfiguration::isUsingS3()) return;

        $storage = FileUploadConfiguration::storage();

        foreach ($storage->allFiles(FileUploadConfiguration::path()) as $filePathname) {
            // On busy websites, this cleanup code can run in multiple threads causing part of the output
            // of allFiles() to have already been deleted by another thread.
            if (! $storage->exists($filePathname)) continue;

            $yesterdaysStamp = now()->subMinutes(20)->timestamp;
            if ($yesterdaysStamp > $storage->lastModified($filePathname)) {
                $storage->delete($filePathname);
            }
        }
    }
}
