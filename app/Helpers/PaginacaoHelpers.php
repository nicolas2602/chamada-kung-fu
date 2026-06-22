<?php

namespace App\Helpers;

class PaginacaoHelpers
{

    /**
     * Retorna a página atual da tabela.
     * @param array $get
     * @return int
     */
    public static function retornarPaginaAtual(array $get) : int
    {
        $paginaAtual = 0;
        if (isset($get['pagina'])) {
            $paginaAtual = (int) $get['pagina'];
        } else {
            $paginaAtual = 1;
        }

        return $paginaAtual;
    }

    /**
     * 
     * @param int $limitePorPaginacao
     * @return int
     */
    public static function calculaInicioPaginacao(int $limitePorPaginacao) : int
    {
        $paginaAtual = self::retornarPaginaAtual($_GET);
        return ($paginaAtual * $limitePorPaginacao) - $limitePorPaginacao;
    }

    /**
     * @param int $totalDados
     * @param int $limitePorPaginacao
     * @return int
     */
    public static function calculaFinalPaginacao(int $totalDados, int $limitePorPaginacao) : int
    {
        return ceil($totalDados / $limitePorPaginacao);
    }

    /**
     * 
     * @param int $limitePorPaginacao
     * @return int
     */
    public static function calculaInicioRegistroTabela(int $limitePorPaginacao) : int
    {
        $paginaAtual = self::retornarPaginaAtual($_GET);
        return (($paginaAtual - 1) * $limitePorPaginacao) + 1;
    }

    /**
     * @param int $totalDados
     * @param int $limitePorPaginacao
     * @return int
     */
    public static function calculaFinalRegistroTabela(int $totalDados, int $limitePorPaginacao) : int
    {
        $paginaAtual = self::retornarPaginaAtual($_GET);
        return min($paginaAtual * $limitePorPaginacao, $totalDados);
    }
}