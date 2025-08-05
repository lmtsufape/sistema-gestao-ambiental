<?php

namespace App\Providers;

use App\Models\WebServiceCaixa\GerirBoletoRemessa;
use App\Models\WebServiceCaixa\IncluirBoletoAvulsoRemessa;
use App\Models\WebServiceCaixa\IncluirBoletoRemessa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        if (config('services.caixa.fake')) {
            Http::fake([
                GerirBoletoRemessa::URL => Http::response($this->fakeCaixaResponse(), 200),
                IncluirBoletoRemessa::URL => Http::response($this->fakeCaixaResponse(), 200),
                IncluirBoletoAvulsoRemessa::URL => Http::response($this->fakeCaixaResponse(), 200),
            ]);
        }
    }

    private function fakeCaixaResponse(): string
    {
        return <<<XML
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">
    <soap:Body>
        <RETORNO_SERVICO>
            <COD_RETORNO><DADOS>0</DADOS></COD_RETORNO>
            <RETORNO><DADOS>SUCESSO</DADOS></RETORNO>
            <CODIGO_BARRAS><DADOS>12345678901234567890123456789012345678901234</DADOS></CODIGO_BARRAS>
            <LINHA_DIGITAVEL><DADOS>12345.67890 12345.678901 23456.789012 3 45670000000000</DADOS></LINHA_DIGITAVEL>
            <URL><DADOS>https://example.com/boleto.pdf</DADOS></URL>
        </RETORNO_SERVICO>
    </soap:Body>
</soap:Envelope>
XML;
    }
}
