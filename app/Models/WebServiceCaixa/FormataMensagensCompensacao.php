<?php

namespace App\Models\WebServiceCaixa;

trait FormataMensagensCompensacao
{
    /**
     * Distribui a mensagem nas duas linhas de 40 caracteres aceitas pela CAIXA.
     *
     * @param string[] $mensagens
     * @return string[]
     */
    protected function formatarMensagensCompensacao(array $mensagens): array
    {
        $mensagens = array_values(array_filter(array_map(function ($mensagem) {
            return trim(preg_replace('/\s+/u', ' ', $mensagem));
        }, $mensagens)));

        if (count($mensagens) > 1) {
            return array_map(function ($mensagem) {
                return mb_substr($mensagem, 0, 40, 'UTF-8');
            }, array_slice($mensagens, 0, 2));
        }

        $mensagem = $mensagens[0] ?? '';

        if ($mensagem === '') {
            return [];
        }

        $mensagem = mb_substr($mensagem, 0, 80, 'UTF-8');
        if (mb_strlen($mensagem, 'UTF-8') <= 40) {
            return [$mensagem];
        }

        $tamanhoMensagem = mb_strlen($mensagem, 'UTF-8');
        $primeirosCaracteres = mb_substr($mensagem, 0, 40, 'UTF-8');
        $posicaoEspaco = mb_strrpos($primeirosCaracteres, ' ', 0, 'UTF-8');
        $posicaoMinima = $tamanhoMensagem - 40;

        $posicaoQuebra = $posicaoEspaco !== false && $posicaoEspaco >= $posicaoMinima
            ? $posicaoEspaco
            : 40;

        return [
            rtrim(mb_substr($mensagem, 0, $posicaoQuebra, 'UTF-8')),
            ltrim(mb_substr($mensagem, $posicaoQuebra, 40, 'UTF-8')),
        ];
    }
}
