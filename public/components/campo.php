<?php

use App\Dto\NivelFaixaDto;
use App\Dto\StatusMatriculaDto;

/**
 * Campos para formulários, especificando o tipo. No entanto, caso for hidden, não formata a estrutura.
 * @param string $label
 * @param string $tipoCampo
 * @param string $nomeCampo
 * @param bool $ehFormatado
 * @return string
 */
function campo(string $label, string $tipoCampo, string $nomeCampo, bool $ehFormatado = true): string
{   
    $html = '';
    $fechaHtml = '';
    if ($ehFormatado) {
        $html .= '<div class="g-2 mb-1">';
        $html .= '<label for="" class="form-label">' . $label . '</label>';
        $fechaHtml = '</div>';
    }

    $html .= '<input type="' . $tipoCampo . '" class="form-control form-control-sm" id="' . $nomeCampo . '" ';
    $html .= 'name="' . $nomeCampo . '">';
    $html .= $fechaHtml;

    return $html;
}

/**
 * @param array<NivelFaixaDto> $niveisFaixas
 * @return string
 */
function campoSelecaoNiveisFaixas(array $niveisFaixas): string
{

    $html = '<div class="g-2 mb-1">';
    $html .= '<label for="" class="form-label">Nível da faixa</label>';
    $html .=  '<select id="nivelFaixa" name="nivelFaixa" class="form-select form-select-sm">';
    $html .= '<option value="" selected>Selecione o nível da faixa</option>';

    foreach ($niveisFaixas as $nivelFaixa) {
        $html .= '<option value="' . $nivelFaixa->idNivelFaixa . '" >';
        $html .= $nivelFaixa->nivelFaixa;
        $html .= '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';

    return $html;
}

/**
 * @param array<StatusMatriculaDto> $statusMatricula
 * @return string
 */
function campoSelecaoStatusMatricula(array $statusMatricula): string
{

    $html = '<div class="g-2 mb-1">';
    $html .= '<label for="" class="form-label">Status da Matrícula</label>';
    $html .=  '<select id="statusMatricula" name="statusMatricula" class="form-select form-select-sm">';
    $html .= '<option value="" selected>Selecione o status da matrícula</option>';

    foreach ($statusMatricula as $matricula) {
        $html .= '<option value="' . $matricula->idStatusMatricula . '" >';
        $html .= $matricula->statusMatricula;
        $html .= '</option>';
    }

    $html .= '</select>';
    $html .= '</div>';

    return $html;
}
