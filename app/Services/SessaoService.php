<?php

namespace App\Services;

use App\Dto\Login\LoginDto;

class SessaoService
{

    /**
     * Inicializa a Session.
     */
    private static function inicializaSessao() : void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Salva os dados do usuário logado.
     * 
     * @param LoginDto $dados
     */
    public static function salvarDadosUsuarioLogado(LoginDto $dados) : void
    {
        self::inicializaSessao();
        session_regenerate_id(true);

        $_SESSION['dadosUsuario'] = json_encode($dados);
    }

    /**
     * Retorna os dados do usuário logado.
     * 
     * @return LoginDto
     */
    public static function retornarDadosUsuarioLogado() : object
    {
        self::inicializaSessao();
        return json_decode($_SESSION['dadosUsuario']);
    }

    /**
     * Verifica se o usuário está logado.
     * 
     * @return bool
     */
    public static function usuarioLogado() : bool
    {
        self::inicializaSessao();
        return isset($_SESSION['dadosUsuario']);
    }

    /**
     * Limpa os dados do usuário logado.
     */
    public static function limparDadosUsuarioLogado() : void
    {
        self::inicializaSessao();
        unset($_SESSION['dadosUsuario']);
        session_destroy();
    }
}
