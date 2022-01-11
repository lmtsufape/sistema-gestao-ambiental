<?php

namespace App\Jobs;

use App\Models\BoletoCobranca;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class BoletoStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $boletos = BoletoCobranca::
                    where('data_vencimento', '>=', today())
                    ->where('status_pagamento', null)
                    ->orWhere('status_pagamento', '!=', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->get();
        foreach($boletos as $boleto){
            $this->atualizarStatusBoleto($boleto);
        }
                
    }

    private function atualizarStatusBoleto(BoletoCobranca $boleto){
        $boleto->status_pagamento = $this->consultaStatus($boleto);
        $boleto->update();
    }

    private function consultaStatus(BoletoCobranca $boleto){
        //teste
        //criar funcao que acessa o web service pra verificar esse status
        return BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'];
    }
}
