<?php

namespace App\Console\Commands;

use App\Models\BoletoCobranca;
use App\Models\WebServiceCaixa\IncluirBoletoRemessa;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class RecuperarNossoNumero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manutencao:recuperarnossonumero';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recupera o atributo nosso_numero do arquivo de resposta da ação de incluir boleto';

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
     * @return void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        BoletoCobranca::whereNull('nosso_numero')
            ->whereNotNull('resposta_incluir_boleto')
            ->lazy()
            ->each(function ($boleto) {
                if (Storage::exists($boleto->resposta_incluir_boleto)) {
                    $response = Storage::disk('local')->get($boleto->resposta_incluir_boleto);
                    if ($response) {
                        $dom_document = new \DOMDocument();
                        $dom_document->loadXML($response);
                        $nosso_numero = $dom_document->getElementsByTagName('NOSSO_NUMERO');
                        if (count($nosso_numero)) {
                            BoletoCobranca::where('id', $boleto->id)->update(['nosso_numero' => $nosso_numero[0]->nodeValue]);
                        }
                    }
                }
            });
    }
}
