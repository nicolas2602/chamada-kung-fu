<?php

function cabecalhoTabela(array $cabecalhoTabela): string
{
    $html = '';
    $html .= '<thead class="table-light">';
    $html .= '<tr>';

    foreach ($cabecalhoTabela as $titulo) {
        $html .= '<th>' . $titulo . '</th>';
    }

    $html .= '</tr>';
    $html .= '</thead>';

    return $html;
}

function corpoTabela(array $corpoTabela, array $cabecalhoTabela): string
{
    $html = '';
    $html .= '<tbody>';
    if (count($corpoTabela) === 0) {
        $html .= "<tr>";
        $html .= "<td class='text-center' colspan=" . count($cabecalhoTabela) . ">";
        $html .= "Nenhum resultado encontrado";
        $html .= "</td>";
        $html .= "</tr>";
    } else {
        foreach ($corpoTabela as $linha) {
            $html .= "<tr>";

            foreach ($linha as $coluna) {
                $html .= "<td>" . $coluna . "</td>";
            }

            $html .= "</tr>";
        }
    }

    $html .= '</tbody>';
    return $html;
}

/**
 * Exibir os registros.
 * 
 * @param array $cabecalhoTabela
 * @param array<array> $corpoTabela
 * @return string
 */
function tabela(array $cabecalhoTabela, array $corpoTabela) : string
{
    $html = '';
    $html .= '<table class="table table-bordered table-sm table-hover">';
    $html .= cabecalhoTabela($cabecalhoTabela);
    $html .= corpoTabela($corpoTabela, $cabecalhoTabela);
    $html .= '</table>';
    return $html;
}
