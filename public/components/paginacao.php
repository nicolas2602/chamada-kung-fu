<?php

use App\Helpers\PaginacaoHelpers;

/**
 * 
 * Limitar o número de registros da tabela dentro da página.
 * 
 * @param int $limitePorPaginacao
 * @param int $totalRegistros
 * @param array $parametrosGet
 * @return void
 */
function paginacao(int $limitePorPaginacao, int $totalRegistros, array $parametrosGet = []): void
{
    $paginaAtual = PaginacaoHelpers::retornarPaginaAtual($_GET);
    $ultimaPagina = PaginacaoHelpers::calculaFinalPaginacao(
        $totalRegistros, 
        $limitePorPaginacao
    );
    $inicioRegistroTabela = PaginacaoHelpers::calculaInicioRegistroTabela($limitePorPaginacao);
    $finalRegistroTabela = PaginacaoHelpers::calculaFinalRegistroTabela(
        $totalRegistros, 
        $limitePorPaginacao
    );

    $montarUrl = function ($pagina) use ($parametrosGet) {
        $parametrosGet['pagina'] = $pagina;
        return '?' . http_build_query($parametrosGet);
    };

    $paginacao = '<nav class="d-flex justify-content-between align-items-center gap-3">';
    $paginacao .= '<ul class="pagination pagination-sm mb-0">';

    if ($paginaAtual > 1) {
        $paginacao .= '<li class="page-item">';
        $paginacao .= '<a class="page-link" href="' . $montarUrl(1) . '">Início</a>';
        $paginacao .= '</li>';
        $paginacao .= '<li class="page-item">';
        $paginacao .= '<a class="page-link" href="' . $montarUrl($paginaAtual - 1) . '">';
        $paginacao .= '<span aria-hidden="true">&laquo;</span>';
        $paginacao .= '</a>';
        $paginacao .= '</li>';
    }

    $maximoPaginasVisiveis = 5;
    $inicio = max(1, $paginaAtual - floor($maximoPaginasVisiveis / 2));
    $fim = min($ultimaPagina, $inicio + $maximoPaginasVisiveis - 1);

    $inicio = max(1, $fim - $maximoPaginasVisiveis + 1);

    for ($i = $inicio; $i <= $fim; $i++) {
        if ($i == $paginaAtual) {
            $paginacao .= '<li class="page-item active">';
            $paginacao .= '<a class="page-link" href="#">' . $i . '</a>';
            $paginacao .= '</li>';
        } else {
            $paginacao .= '<li class="page-item">';
            $paginacao .= '<a class="page-link" href="' . $montarUrl($i) . '">' . $i . '</a> ';
            $paginacao .= '</li>';
        }
    }

    if ($paginaAtual < $ultimaPagina) {
        $paginacao .= '<li class="page-item">';
        $paginacao .= '<a class="page-link" href="' . $montarUrl($paginaAtual + 1) . '">';
        $paginacao .= '<span aria-hidden="true">&raquo;</span>';
        $paginacao .= '</a>';
        $paginacao .= '</li>';
        $paginacao .= '<li class="page-item">';
        $paginacao .= '<a class="page-link" href="' . $montarUrl($ultimaPagina) .'"> Último </a>';
        $paginacao .= '</li>';
    }

    $paginacao .= '</ul>';
    $paginacao .= '<span class="text-muted small">';
    $paginacao .= 'Mostrando de ' . $inicioRegistroTabela . '-' . $finalRegistroTabela;
    $paginacao .= ' de ' . $totalRegistros . ' registros';
    $paginacao .= '</span>';
    $paginacao .= '</nav>';

    echo $paginacao;
}
