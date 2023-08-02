<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Requerimento;
use App\Models\RequerimentoDocumento;
use Datetime;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrazoExigenciasExpirado;

class EnviarEmailAlertaPrazo extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:emailAlertaPrazo';

     /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email de alerta para o usuário quando o prazo de exigências expirar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $requerimento_documentos = RequerimentoDocumento::whereNotNull('prazo_exigencia')->get();
        foreach ($requerimento_documentos as $requerimento_documento) {
            $prazoExigencias = new DateTime($requerimento_documento->prazo_exigencia);
            $agora = new DateTime();
            
            if ($agora > $prazoExigencias) {
                $this->enviarEmailAlerta($requerimento_documento->id);
            }
        }
    }

    public function enviarEmailAlerta($requerimento_documento_id)
    {
        $requerimento_documentos = RequerimentoDocumento::find($requerimento_documento_id);
        $to = $requerimento_documentos->empresa->user->email;
        $subject = 'Prazo Expirado';
        $data = [
            'requerimento_documento' => $requerimento_documentos,
        ];
                
        Mail::to($to)->send(new PrazoExigenciasExpirado($subject, $data));
        
    }
}