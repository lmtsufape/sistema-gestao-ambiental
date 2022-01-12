<?php

namespace App\Console\Commands;

use App\Models\BoletoCobranca;
use Illuminate\Console\Command;

class AtualizarStatusBoletos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atualizar:boletos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o status de pagamento dos boletos não vencidos ainda não pagos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
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
