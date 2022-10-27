<?php

namespace App\Http\Controllers;

use App\Models\BoletoCobranca;
use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\Licenca;
use App\Models\Noticia;
use App\Models\Requerimento;
use App\Models\SolicitacaoMuda;
use App\Models\SolicitacaoPoda;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
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


        if (auth()->user() && auth()->user()->role == User::ROLE_ENUM['secretario']) {
            $ordenacao = $request->ordenacao;

            switch ($ordenacao) {
                case '7_dias':
                    $data = $this->requerimentosPieChart(Carbon::now()->subWeek());
                    $mudasData = $this->mudasPieChart(Carbon::now()->subWeek());
                    $podasData = $this->podasPieChart(Carbon::now()->subWeek());
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subWeek());
                    $licencasData = $this->licencasPieChart(Carbon::now()->subWeek());
                    $boletoData = $this->totalBoleto(Carbon::now()->subWeek());
                    $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subWeek());

                    break;
                case 'ultimo_mes':
                    $data = $this->requerimentosPieChart(Carbon::now()->subMonth());
                    $mudasData = $this->mudasPieChart(Carbon::now()->subMonth());
                    $podasData = $this->podasPieChart(Carbon::now()->subMonth());
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subMonth());
                    $licencasData = $this->licencasPieChart(Carbon::now()->subMonth());
                    $boletoData = $this->totalBoleto(Carbon::now()->subMonth());
                    $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subMonth());

                    break;
                case 'meses':
                    $data = $this->requerimentosPieChart(Carbon::now()->subYear());
                    $mudasData = $this->mudasPieChart(Carbon::now()->subYear());
                    $podasData = $this->podasPieChart(Carbon::now()->subYear());
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subYear());
                    $licencasData = $this->licencasPieChart(Carbon::now()->subYear());
                    $boletoData = $this->totalBoleto(Carbon::now()->subYear());
                    $pagamentos = $this->pagamentosChart($ordenacao, 'month', Carbon::now()->subYear());

                    break;
                case 'anos':
                    $data = $this->requerimentosPieChart(Carbon::now()->subYears(5));
                    $mudasData = $this->mudasPieChart(Carbon::now()->subYears(5));
                    $podasData = $this->podasPieChart(Carbon::now()->subYears(5));
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subYears(5));
                    $licencasData = $this->licencasPieChart(Carbon::now()->subYears(5));
                    $boletoData = $this->totalBoleto(Carbon::now()->subYears(5));
                    $pagamentos = $this->pagamentosChart($ordenacao, 'year', Carbon::now()->subYears(5));

                    break;
                default:
                    if ($request->dataDe != null || $request->dataAte != null){
                        $data = $this->requerimentosPieChart(Carbon::now()->subWeek(), $request);
                        $mudasData = $this->mudasPieChart(Carbon::now()->subWeek(), $request);
                        $podasData = $this->podasPieChart(Carbon::now()->subWeek(), $request);
                        $denunciasData = $this->denunciasPieChart(Carbon::now()->subWeek(), $request);
                        $licencasData = $this->licencasPieChart(Carbon::now()->subWeek(), $request);
                        $boletoData = $this->totalBoleto(Carbon::now()->subWeek(), $request);
                        $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subWeek(), $request);
                    } else {
                        $data = $this->requerimentosPieChart(Carbon::now()->subWeek());
                        $mudasData = $this->mudasPieChart(Carbon::now()->subWeek());
                        $podasData = $this->podasPieChart(Carbon::now()->subWeek());
                        $denunciasData = $this->denunciasPieChart(Carbon::now()->subWeek());
                        $licencasData = $this->licencasPieChart(Carbon::now()->subWeek());
                        $boletoData = $this->totalBoleto(Carbon::now()->subWeek());

                        $ordenacao = '7_dias';
                        $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subWeek());
                    }

                    break;
            }
            $titulo = $this->titulo($ordenacao);
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;

            return view('welcome', compact('noticias', 'empresas', 'data', 'pagamentos', 'titulo', 'ordenacao', 'boletoData', 'mudasData', 'podasData', 'denunciasData', 'licencasData', 'dataDe', 'dataAte'));
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
            default:
                $titulo = "Boletos pagos no período informado";
                break;
        }
        return $titulo;
    }

    private function totalBoleto($periodo, $request = null) {
        $query = BoletoCobranca::where('created_at', '!=', null);
        $query2 = BoletoCobranca::where('created_at', '!=', null);
        $query3 = BoletoCobranca::where('created_at', '!=', null);

        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $query = $query->where('created_at', '>=', $dataDe);
                $query2 = $query2->where('created_at', '>=', $dataDe);
                $query3 = $query3->where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $query = $query->where('created_at', '<=', $dataAte);
                $query2 = $query2->where('created_at', '<=', $dataAte);
                $query3 = $query3->where('created_at', '<=', $dataAte);
            }
        } else {
            $query = BoletoCobranca::where('created_at', '>=', $periodo);
            $query2 = BoletoCobranca::where('created_at', '>=', $periodo);
            $query3 = BoletoCobranca::where('created_at', '>=', $periodo);
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

    private function pagamentosChart($ordenacao, $group, $periodo, $request = null) {
        $data = BoletoCobranca::where('status_pagamento', BoletoCobranca::STATUS_PAGAMENTO_ENUM['pago']);
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = $data->where('data_pagamento', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = $data->where('data_pagamento', '<=', $dataAte);
            }

            $newData = clone $data;

            $menor = $newData->orderBy('data_pagamento', 'ASC')->first();
            $maior = $newData->orderBy('data_pagamento', 'ASC')->first();

            if ($menor != null && $maior != null) {
                $datetime1 = new DateTime($menor->data_pagamento);
                $datetime2 = new DateTime($maior->data_pagamento);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->days;
            } else {
                $days = 0;
            }

            if ($days <= 31) {
                $ordenacao = 'ultimo_mes';
                $group = 'day';
            } elseif ($days > 365) {
                $ordenacao = 'anos';
                $group = 'year';
            } else {
                $ordenacao = 'meses';
                $group = 'month';
            }
        } else {
            $data = $data->where('data_pagamento', '>=', $periodo);
        }


        $data = $data->join('requerimentos', 'requerimentos.id', '=', 'boleto_cobrancas.requerimento_id');

        switch ($ordenacao) {
            case '7_dias':
                $collection = $data->selectRaw("
                sum(requerimentos.valor) AS sum,
                extract(DAY FROM boleto_cobrancas.data_pagamento) AS day
                ");
                break;
            case 'ultimo_mes':
                $collection = $data->selectRaw("
                sum(requerimentos.valor) AS sum,
                extract(DAY FROM boleto_cobrancas.data_pagamento) AS day
                ");
                break;
            case 'meses':
                $collection = $data->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(MONTH FROM boleto_cobrancas.data_pagamento) AS month
                    ");
                break;
            case 'anos':
                $collection = $data->selectRaw("
                    sum(requerimentos.valor) AS sum,
                    extract(YEAR FROM boleto_cobrancas.data_pagamento) AS year
                    ");
                break;
        }

        $collection = $collection->orderBy($group)
        ->groupBy($group)
        ->get();

        $pagamentos = $collection->toArray();
        $pagamentos = array_reduce($pagamentos, function ($result, $item) use ($group) {
            $result[$item[$group]] = $item['sum'];
            return $result;
        }, array());

        return $pagamentos;
    }

    private function requerimentosPieChart($periodo, $request = null) {
        $data = Requerimento::where('status', '!=', Requerimento::STATUS_ENUM['cancelada']);

        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = $data->where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = $data->where('created_at', '<=', $dataAte);
            }
        } else {
            $data = $data->where('created_at', '>=', $periodo);
        }
        $data = $data->get()
        ->groupBy('status_string')
        ->map->count();

        $canceladas = Requerimento::where('created_at', '>=', $periodo)
        ->where('status', Requerimento::STATUS_ENUM['cancelada'])
        ->orWhere('cancelada', true)
        ->count();
        if ($canceladas > 0) {
            $data['Cancelados'] = $canceladas;
        }

        return $data;
    }

    private function mudasPieChart($periodo, $request = null) {
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = SolicitacaoMuda::where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = SolicitacaoMuda::where('created_at', '<=', $dataAte);
            }
        } else {
            $data = SolicitacaoMuda::where('created_at', '>=', $periodo);
        }
        $data = $data->get()
        ->groupBy('status_string')
        ->map->count();

        return $data;
    }

    private function podasPieChart($periodo, $request = null) {
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = SolicitacaoPoda::where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = SolicitacaoPoda::where('created_at', '<=', $dataAte);
            }
        } else {
            $data = SolicitacaoPoda::where('created_at', '>=', $periodo);
        }
        $data = $data->get()
        ->groupBy('status_string')
        ->map->count();

        return $data;
    }

    private function denunciasPieChart($periodo, $request = null) {
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = Denuncia::where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = Denuncia::where('created_at', '<=', $dataAte);
            }
        } else {
            $data = Denuncia::where('created_at', '>=', $periodo);
        }
        $data = $data->get()
        ->groupBy('status_string')
        ->map->count();

        return $data;
    }

    private function licencasPieChart($periodo, $request = null) {
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $data = Licenca::where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $data = Licenca::where('created_at', '<=', $dataAte);
            }
        } else {
            $data = Licenca::where('created_at', '>=', $periodo);
        }
        $data = $data->get()
        ->groupBy('status_string')
        ->map->count();

        return $data;
    }
}
