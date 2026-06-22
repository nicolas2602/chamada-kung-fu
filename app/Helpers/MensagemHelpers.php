<?php

namespace App\Helpers;

class MensagemHelpers
{   
    /**
     * @param string $mensagem
     */
    public static function sucesso(string $mensagem) : void
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['tipoMensagem'] = 'success';
    }

    /**
     * @param string $mensagem
     */
    public static function erro(string $mensagem) : void
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['tipoMensagem'] = 'danger';
    }

    /**
     * @param string $mensagem
     */
    public static function aviso(string $mensagem) : void
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['tipoMensagem'] = 'warning';
    }

    /**
     * @return array{
     * 'mensagem': string,
     * 'tipoMensagem': string
     * } | false
     */
    public static function retornaMensagem() : array|false
    {
        if(!isset($_SESSION['mensagem'])){
            return false;
        }

        $mensagem = $_SESSION['mensagem'];
        $tipoMensagem = $_SESSION['tipoMensagem'];

        unset($_SESSION['mensagem'], $_SESSION['tipoMensagem']);

        return [
            'mensagem' => $mensagem,
            'tipoMensagem' => $tipoMensagem
        ];
    }
}