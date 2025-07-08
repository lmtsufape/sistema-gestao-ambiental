<?php

namespace App\Http\Controllers;

use App\Models\BoletoCobranca;
use App\Models\Denuncia;
use App\Models\Empresa;
use App\Models\Licenca;
use App\Models\Noticia;
use App\Models\Notificacao;
use App\Models\Requerimento;
use App\Models\SolicitacaoMuda;
use App\Models\SolicitacaoPoda;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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
                    $notificacoes = $this->getNotificacoes(Carbon::now()->subWeek());

                    break;
                case 'ultimo_mes':
                    $data = $this->requerimentosPieChart(Carbon::now()->subMonth());
                    $mudasData = $this->mudasPieChart(Carbon::now()->subMonth());
                    $podasData = $this->podasPieChart(Carbon::now()->subMonth());
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subMonth());
                    $licencasData = $this->licencasPieChart(Carbon::now()->subMonth());
                    $boletoData = $this->totalBoleto(Carbon::now()->subMonth());
                    $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subMonth());
                    $notificacoes = $this->getNotificacoes(Carbon::now()->subMonth());

                    break;
                case 'meses':
                    $data = $this->requerimentosPieChart(Carbon::now()->subYear());
                    $mudasData = $this->mudasPieChart(Carbon::now()->subYear());
                    $podasData = $this->podasPieChart(Carbon::now()->subYear());
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subYear());
                    $licencasData = $this->licencasPieChart(Carbon::now()->subYear());
                    $boletoData = $this->totalBoleto(Carbon::now()->subYear());
                    $pagamentos = $this->pagamentosChart($ordenacao, 'month', Carbon::now()->subYear());
                    $notificacoes = $this->getNotificacoes(Carbon::now()->subYear());

                    break;
                case 'anos':
                    $data = $this->requerimentosPieChart(Carbon::now()->subYears(5));
                    $mudasData = $this->mudasPieChart(Carbon::now()->subYears(5));
                    $podasData = $this->podasPieChart(Carbon::now()->subYears(5));
                    $denunciasData = $this->denunciasPieChart(Carbon::now()->subYears(5));
                    $licencasData = $this->licencasPieChart(Carbon::now()->subYears(5));
                    $boletoData = $this->totalBoleto(Carbon::now()->subYears(5));
                    $pagamentos = $this->pagamentosChart($ordenacao, 'year', Carbon::now()->subYears(5));
                    $notificacoes = $this->getNotificacoes(Carbon::now()->subYears(5));

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
                        $notificacoes = $this->getNotificacoes(Carbon::now()->subWeek(), $request);
                    } else {
                        $data = $this->requerimentosPieChart(Carbon::now()->subWeek());
                        $mudasData = $this->mudasPieChart(Carbon::now()->subWeek());
                        $podasData = $this->podasPieChart(Carbon::now()->subWeek());
                        $denunciasData = $this->denunciasPieChart(Carbon::now()->subWeek());
                        $licencasData = $this->licencasPieChart(Carbon::now()->subWeek());
                        $boletoData = $this->totalBoleto(Carbon::now()->subWeek());

                        $ordenacao = '7_dias';
                        $pagamentos = $this->pagamentosChart($ordenacao, 'day', Carbon::now()->subWeek());
                        $notificacoes = $this->getNotificacoes(Carbon::now()->subWeek());

                    }

                    break;
            }
            $titulo = $this->titulo($ordenacao);
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;

            return view('dashboard.secretario', compact('data', 'pagamentos', 'titulo', 'ordenacao', 'boletoData', 'mudasData', 'podasData', 'denunciasData', 'licencasData', 'dataDe', 'dataAte', 'notificacoes'));
        }
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

    private function getNotificacoes($periodo, $request = null)
    {
        $notificacoes = Notificacao::where('created_at', '!=', null);
        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $notificacoes = $notificacoes->where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $notificacoes = $notificacoes->where('created_at', '<=', $dataAte);
            }
        }
        else {
            $notificacoes = $notificacoes->where('created_at', '>=', $periodo);
        }

        if($notificacoes->count() > 0){
            return $notificacoes->get();
        }
        else{
            return $notificacoes;
        }

    }

    private function totalBoleto($periodo, $request = null) {
        $boletos = BoletoCobranca::whereNotNull('created_at')->get();

        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $boletos = $boletos->where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $boletos = $boletos->where('created_at', '<=', $dataAte);
            }
        } else {
            $boletos = $boletos->where('created_at', '>=', $periodo);
        }

        $labelsStatusPagamento = BoletoCobranca::statusPagamentoRotulos();

        $boletoData = $boletos
            ->groupBy('status_pagamento')
            ->mapWithKeys(fn ($grupo, $status) => [
                $labelsStatusPagamento[$status] ?? 'Desconhecido' => $grupo->count()
            ]);

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
        $requerimentos = Requerimento::all();

        if ($request != null) {
            $dataDe = $request->dataDe;
            $dataAte = $request->dataAte;
            if ($dataDe != null) {
                $requerimentos = $requerimentos->where('created_at', '>=', $dataDe);
            }
            if ($dataAte != null) {
                $requerimentos = $requerimentos->where('created_at', '<=', $dataAte);
            }
        } else if($periodo) {
            $requerimentos = $requerimentos->where('created_at', '>=', $periodo);
        }

        $data = [
            'Cancelados' => $requerimentos->filter(function($requerimento){
                return $requerimento->status === Requerimento::STATUS_ENUM['cancelada'] || $requerimento->cancelada === true;
            })->count(),
            'Em andamento' => $requerimentos->where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])->where('status', '!=', Requerimento::STATUS_ENUM['finalizada'])->count(),
            'Aprovados'  => $requerimentos->where('status', '!=', Requerimento::STATUS_ENUM['finalizada'])->count(),
        ];

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
