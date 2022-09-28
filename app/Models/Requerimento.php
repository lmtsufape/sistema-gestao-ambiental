<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimento extends Model
{
    use HasFactory;

    public const STATUS_ENUM = [
        'requerida' => 1,
        'em_andamento' => 2,
        'documentos_requeridos' => 3,
        'documentos_enviados' => 4,
        'documentos_aceitos' => 5,
        'visita_marcada' => 6,
        'visita_realizada' => 7,
        'finalizada' => 8,
        'cancelada' => 9,
    ];

    public const DEFINICAO_VALOR_ENUM = [
        'manual' => 'Definir de forma manual',
        'automatica' => 'Definir de forma automática',
        'automatica_com_juros' => 'Definir de forma automática com juros',
    ];

    public const TIPO_ENUM = [
        'primeira_licenca' => 1,
        'renovacao' => 2,
        'autorizacao' => 3,
    ];

    public const TIPO_LICENCA_ENUM = Licenca::TIPO_ENUM;

    protected $fillable = [
        'status',
        'tipo',
        'valor',
        'potencial_poluidor_atribuido',
        'cancelada',
        'motivo_cancelamento',
        'status_requerimento',
    ];

    public function protocolista()
    {
        return $this->belongsTo(User::class, 'analista_id');
    }

    public function analistaProcesso()
    {
        return $this->belongsTo(User::class, 'analista_processo_id');
    }

    public function represetanteLegalEmpresa()
    {
        return $this->belongsTo(RepresetanteLegal::class, 'represetante_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function licenca()
    {
        return $this->hasOne(Licenca::class, 'requerimento_id');
    }

    public function documentos()
    {
        return $this->belongsToMany(Documento::class, 'checklists', 'requerimento_id', 'documento_id')->withPivot('caminho', 'comentario', 'status');
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'requerimento_id');
    }

    public function boletos()
    {
        return $this->hasMany(BoletoCobranca::class, 'requerimento_id')->orderBy('created_at', 'ASC');
    }

    public function tipoString()
    {
        switch ($this->tipo) {
            case $this::TIPO_ENUM['primeira_licenca']:
                return 'primeira licença';
                break;
            case $this::TIPO_ENUM['renovacao']:
                return 'renovação';
                break;
            case $this::TIPO_ENUM['autorizacao']:
                return 'autorização';
                break;
            default:
                return '';
                break;
        }
    }

    public function status()
    {
        switch ($this->status) {
            case $this::STATUS_ENUM['requerida']:
                return 'requerido';
                break;
            case $this::STATUS_ENUM['em_andamento']:
                return 'em andamento';
                break;
            case $this::STATUS_ENUM['documentos_requeridos']:
                return 'documentos requeridos';
                break;
            case $this::STATUS_ENUM['documentos_enviados']:
                return 'documentos enviados';
                break;
            case $this::STATUS_ENUM['documentos_aceitos']:
                return 'documentos aceitos';
                break;
            case $this::STATUS_ENUM['visita_marcada']:
                return 'visita marcada para até ' . date('d/m/Y', strtotime($this->ultimaVisitaMarcada()->data_marcada));
                break;
            case $this::STATUS_ENUM['visita_realizada']:
                return 'visita feita em ' . date('d/m/Y', strtotime($this->ultimaVisitaMarcada()->data_realizada));
                break;
            case $this::STATUS_ENUM['finalizada']:
                return 'finalizado';
                break;
            case $this::STATUS_ENUM['cancelada']:
                return 'cancelado';
                break;
            default:
                return '';
                break;
        }
    }

    public function getStatusStringAttribute()
    {
        return ucwords(str_replace('_', ' ', array_search($this->status, $this::STATUS_ENUM)));
    }

    public function tipoDeLicenca()
    {
        switch ($this->tipo_licenca) {
            case $this::TIPO_LICENCA_ENUM['previa']:
                return 'prévia';
                break;
            case $this::TIPO_LICENCA_ENUM['instalacao']:
                return 'instalação';
                break;
            case $this::TIPO_LICENCA_ENUM['operacao']:
                return 'operação';
                break;
            case $this::TIPO_LICENCA_ENUM['simplificada']:
                return 'simplificada';
                break;
            case $this::TIPO_LICENCA_ENUM['autorizacao_ambiental']:
                return 'autorização ambiental';
                break;
            case $this::TIPO_LICENCA_ENUM['regularizacao']:
                return 'regularização';
                break;
        }
    }

    public function tituloTipoDeLicenca()
    {
        $titulo = "Licença ";
        if ($this->tipoDeLicenca() != 'simplificada' && $this->tipoDeLicenca() != 'prévia') {
            $titulo .= "de ";
        }

        return $titulo.$this->tipoDeLicenca();
    }

    public function ultimaVisitaMarcada()
    {
        return $this->visitas()->latest('data_marcada')->first();
    }

    public function ultimaVisitaRelatorioAceito()
    {
        return $this->visitas()->whereHas('relatorio', function (Builder $qry) {
            $qry->where('aprovacao', '=', Relatorio::APROVACAO_ENUM['aprovado']);
        })
        ->latest('data_marcada')->first();
    }

    public function gerarMensagemCompesacao()
    {
        switch ($this->tipo) {
            case $this::TIPO_ENUM['primeira_licenca']:
                return [
                    'TAXA DE PRIMEIRA LICENCA ' . $this->tipoDeLicencaCompensacao(),
                ];
                break;
            case $this::TIPO_ENUM['renovacao']:
                return [
                    'TAXA DE RENOVACAO DA LICENCA ' . $this->tipoDeLicencaCompensacao(),
                ];
                break;
            case $this::TIPO_ENUM['autorizacao']:
                return [
                    'TAXA DE ' . $this->tipoDeLicencaCompensacao(),
                ];
                break;
        }
    }

    private function tipoDeLicencaCompensacao()
    {
        switch ($this->tipo_licenca) {
            case $this::TIPO_LICENCA_ENUM['previa']:
                return 'PREVIA';
                break;
            case $this::TIPO_LICENCA_ENUM['instalacao']:
                return 'INSTALACAO';
                break;
            case $this::TIPO_LICENCA_ENUM['operacao']:
                return 'OPERACAO';
                break;
            case $this::TIPO_LICENCA_ENUM['simplificada']:
                return 'SIMPLIFICADA';
                break;
            case $this::TIPO_LICENCA_ENUM['autorizacao_ambiental']:
                return 'AUTORIZACAO AMBIENTAL';
                break;
            case $this::TIPO_LICENCA_ENUM['regularizacao']:
                return 'REGULARIZACAO';
                break;
        }
    }

    public function textoEtapa()
    {
        switch ($this->status) {
            case $this::STATUS_ENUM['requerida']:
                return 'Seu requerimento será enviado para o banco de requerimentos da secretaria.';
                break;
            case $this::STATUS_ENUM['em_andamento']:
                return 'Seu requerimento está sendo analisado por um dos protocolistas';
                break;
            case $this::STATUS_ENUM['documentos_requeridos']:
                return 'Envie os documentos solicitados pelo protocolista.';
                break;
            case $this::STATUS_ENUM['documentos_enviados']:
                return 'Seus documentos foram recebidos e serão analisados por um analista.';
                break;
            case $this::STATUS_ENUM['documentos_aceitos']:
                return 'Seus documentos foram aprovados, aguarde o agendamento da visita à empresa/serviço.';
                break;
            case $this::STATUS_ENUM['visita_marcada']:
                return 'A visita à empresa/serviço ' . $this->empresa->nome . ' foi agendada, aguarde a equipe da secretaria na data informada.';
                break;
            case $this::STATUS_ENUM['visita_realizada']:
                return 'A visita à empresa/serviço ' . $this->empresa->nome . 'foi realizada, aguarde a análise da secretaria para receber sua licença.';
                break;
            case $this::STATUS_ENUM['finalizada']:
                return 'Licença aprovada! Acesse o documento clicando no botão de "Visualizar licença".';
                break;
            case $this::STATUS_ENUM['cancelada']:
                return 'Você cancelou o seu requerimento. Desfaça o cancelamento do mesmo clicando no ícone de "Cancelar requerimento".';
                break;
            default:
                return '';
                break;
        }
    }

    public function cancelado()
    {
        return $this->status == $this::STATUS_ENUM['cancelada'] || $this->cancelada;
    }

    public function canceladoSecretario()
    {
        return $this->cancelada;
    }
}
