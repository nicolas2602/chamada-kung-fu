<?php

namespace App\Helpers;

class Logger
{
    /**
     * Mensagem de informação.
     * @param string $mensagem
     * @return void
     */
    public static function info(string $mensagem) : void
    {
        error_log("INFO - " . $mensagem);
    }

    /**
     * Mensagem de erro.
     * @param string $mensagem
     * @return void
     */
    public static function error(string $mensagem) : void
    {
        error_log("ERROR - " . $mensagem);
    }
}