<?php

namespace App\Http\Controllers;

use App\Models\BoletoCobranca;
use App\Models\Empresa;
use App\Models\Noticia;
use App\Models\Requerimento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $noticias = Noticia::where([['destaque', true], ['publicada', true]])->orderBy('created_at', 'DESC')->get();
        $empresas = Empresa::whereRelation('requerimentos', 'status' , "!=", Requerimento::STATUS_ENUM['cancelada'])
        ->whereRelation('requerimentos', 'cancelada' , "=", false)
        ->orderBy('nome')
        ->get()->map
        ->only(['id', 'nome', 'cpf_cnpj']);


        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            $ordenacao = $request->ordenacao;


            switch ($ordenacao) {
                case '7_dias':
                    $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->get()
                    ->groupBy('status_string')
                    ->map->count();

                    $canceladas = Requerimento::where('created_at', '>=', Carbon::now()->subWeek())
                    ->where('status', Requerimento::STATUS_ENUM['cancelada'])
                    ->orWhere('cancelada', true)
                    ->count();
                    if ($canceladas > 0) {
                        $data['Cancelados'] = $canceladas;
                    }

                    $boletoData = $this->totalBoleto($ordenacao);

                    $collection = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->where('data_pagamento', '>=', Carbon::now()->subWeek())
                    ->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id')
                    ->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(DAY FROM boleto_cobrancas.data_pagamento) AS day
                    ")
                    ->orderBy('day')
                    ->groupBy('day')

                    ->get();

                    $pagamentos = $collection->toArray();
                    $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                        $result[$item['day']] = $item['sum'];
                        return $result;
                    }, array());
                    break;
                case 'ultimo_mes':
                    $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
                    ->where('created_at', '>=', Carbon::now()->subMonth())
                    ->get()
                    ->groupBy('status_string')
                    ->map->count();

                    $canceladas = Requerimento::where('created_at', '>=', Carbon::now()->subMonth())
                    ->where('status', Requerimento::STATUS_ENUM['cancelada'])
                    ->orWhere('cancelada', true)
                    ->count();
                    if ($canceladas > 0) {
                        $data['Cancelados'] = $canceladas;
                    }

                    $boletoData = $this->totalBoleto($ordenacao);

                    $collection = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->where('data_pagamento', '>=', Carbon::now()->subMonth())
                    ->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id')
                    ->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(DAY FROM boleto_cobrancas.data_pagamento) AS day
                    ")
                    ->orderBy('day')
                    ->groupBy('day')
                    ->get();

                    $pagamentos = $collection->toArray();
                    $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                        $result[$item['day']] = $item['sum'];
                        return $result;
                    }, array());
                    break;
                case 'meses':
                    $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
                    ->where('created_at', '>=', Carbon::now()->subYear())
                    ->get()
                    ->groupBy('status_string')
                    ->map->count();

                    $canceladas = Requerimento::where('created_at', '>=', Carbon::now()->subYear())
                    ->where('status', Requerimento::STATUS_ENUM['cancelada'])
                    ->orWhere('cancelada', true)
                    ->count();
                    if ($canceladas > 0) {
                        $data['Cancelados'] = $canceladas;
                    }

                    $boletoData = $this->totalBoleto($ordenacao);

                    $collection = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->where('data_pagamento', '>=', Carbon::now()->subYear())
                    ->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id')
                    ->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(MONTH FROM boleto_cobrancas.data_pagamento) AS month
                    ")
                    ->orderBy('month')
                    ->groupBy('month')
                    ->get();

                    $pagamentos = $collection->toArray();
                    $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                        $result[$item['month']] = $item['sum'];
                        return $result;
                    }, array());
                    break;
                case 'anos':
                    $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
                    ->where('created_at', '>=', Carbon::now()->subYear(5))
                    ->get()
                    ->groupBy('status_string')
                    ->map->count();

                    $canceladas = Requerimento::where('created_at', '>=', Carbon::now()->subYear(5))
                    ->where('status', Requerimento::STATUS_ENUM['cancelada'])
                    ->orWhere('cancelada', true)
                    ->count();
                    if ($canceladas > 0) {
                        $data['Cancelados'] = $canceladas;
                    }

                    $boletoData = $this->totalBoleto($ordenacao);

                    $collection = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->where('data_pagamento', '>=', Carbon::now()->subYears(5))
                    ->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id')
                    ->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(YEAR FROM boleto_cobrancas.data_pagamento) AS year
                    ")
                    ->orderBy('year')
                    ->groupBy('year')
                    ->get();
                    $pagamentos = $collection->toArray();
                    $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                        $result[$item['year']] = $item['sum'];
                        return $result;
                    }, array());
                    break;
                default:
                    $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
                    ->where('created_at', '>=', Carbon::now()->subWeek())
                    ->get()
                    ->groupBy('status_string')
                    ->map->count();

                    $canceladas = Requerimento::where('created_at', '>=', Carbon::now()->subWeek())
                    ->where('status', Requerimento::STATUS_ENUM['cancelada'])
                    ->orWhere('cancelada', true)
                    ->count();
                    if ($canceladas > 0) {
                        $data['Cancelados'] = $canceladas;
                    }

                    $boletoData = $this->totalBoleto('7_dias');

                    $ordenacao = '7_dias';
                    $collection = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
                    ->where('data_pagamento', '>=', Carbon::now()->subWeek())
                    ->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id')
                    ->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(DAY FROM boleto_cobrancas.data_pagamento) AS day
                    ")
                    ->orderBy('day')
                    ->groupBy('day')
                    ->get();
                    $pagamentos = $collection->toArray();
                    $pagamentos = array_reduce($pagamentos, function ($result, $item) {
                        $result[$item['day']] = $item['sum'];
                        return $result;
                    }, array());
                    break;
            }
            $titulo = $this->titulo($ordenacao);

            return view('welcome', compact('noticias', 'empresas', 'data', 'pagamentos', 'titulo', 'ordenacao', 'boletoData'));
        }


        return view('welcome', compact('noticias', 'empresas'));
    }

    private function titulo($ordenacao) {
        switch ($ordenacao) {
            case '7_dias':
                $titulo = "Boletos pagos nos últimos 7 dias";
                break;
            case 'ultimo_mes':
                $titulo = "Boletos pagos nos últimos 30 dias";
                break;
            case 'meses':
                $titulo = "Boletos pagos nos últimos 12 meses";
                break;
            case 'anos':
                $titulo = "Boletos pagos nos últimos 5 anos";
                break;
        }
        return $titulo;
    }

    private function totalBoleto($ordenacao) {
        switch ($ordenacao) {
            case '7_dias':
                $query = BoletoCobranca::where('created_at', '>=', Carbon::now()->subWeek());
                $query2 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subWeek());
                $query3 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subWeek());
                break;
            case 'ultimo_mes':
                $query = BoletoCobranca::where('created_at', '>=', Carbon::now()->subMonth());
                $query2 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subMonth());
                $query3 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subMonth());
                break;
            case 'meses':
                $query = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear());
                $query2 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear());
                $query3 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear());
                break;
            case 'anos':
                $query = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear(5));
                $query2 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear());
                $query3 = BoletoCobranca::where('created_at', '>=', Carbon::now()->subYear());
                break;
        }
        $boletoData = array();

        $vencidos = $query
        ->where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['vencido'])
        ->count();
        if ($vencidos > 0) {
            $boletoData['Vencidos'] = $vencidos;
        }

        $pagos = $query2
        ->where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago'])
        ->count();
        if ($pagos > 0) {
            $boletoData['Pagos'] = $pagos;
        }

        $pendentes = $query3
        ->where(function ($qry) {
            $qry->whereNull('status_pagamento')
                ->orWhere('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['nao_pago']);
        })->count();

        if ($pendentes > 0) {
            $boletoData['Pendentes'] = $pendentes;
        }

        return $boletoData;
    }
}
