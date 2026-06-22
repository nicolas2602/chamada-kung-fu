<?php

namespace App\Helpers;

class FormularioHelpers {

    /**
     * 
     * Preenche os campos do tipo POST.
     * 
     * @param array $campos
     * @param array $request
     * @return array
     */
    public static function capturarCampos(array &$campos, array &$request) : array
    {
        $dados = [];

        foreach ($campos as $campo) {
            $valor = '';

            if(isset($request[$campo])){
                $valor = $request[$campo];
            }

            $dados[$campo] = $valor;
        }

        return $dados;
    }

    /**
     * Converte timestamp para o formato data
     * 
     * @param int $timestamp
     * @param string $formatoData
     * @return string
     */
    public static function converterTimestampParaData(int $timestamp, string $formatoData = "d/m/Y"): string
    {
        $dataFormatada = date($formatoData, $timestamp);
        return $dataFormatada;
    }

    /**
     * Converte a data americana para data brasileira.
     * 
     * @param string $data
     * @return string
     */
    public static function converterParaDataBrasileira(string $data) : string
    {
        $converteDataBrasileira = strtotime($data);
        $dataBrasileira = self::converterTimestampParaData($converteDataBrasileira);
        return $dataBrasileira;
    }

    /**
     * Retorna o dia da semana em números.
     * 
     * - 1 = segunda
     * - 2 = terça
     * - 3 = quarta
     * - 4 = quinta
     * - 5 = sexta
     * - 6 = sábado
     * - 7 = domingo
     * 
     * @param int $timestamp - O tempo em milissegundos
     * @return string
     */
    public static function retornaDiaSemana(int $timestamp)
    {
        $diaSemana = self::converterTimestampParaData($timestamp, 'N');
        return $diaSemana;
    }
}