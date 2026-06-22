<?php 

namespace App\Controller;

use Config\Conexao;
use App\Helpers\Logger;
use App\Helpers\MensagemHelpers;
use App\Services\LoginService;
use App\Services\SessaoService;

/**
 * @property LoginService $service
 */
class LoginController {

    private LoginService $service;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao){
        $this->service = new LoginService($conexao);
    }

    /**
     * Redireciona para a página de login.
     * @return void
     */
    public function logout(): void
    {
        SessaoService::limparDadosUsuarioLogado();
        Logger::info("Saindo da página...");
        header('location: /public');
        exit;
    }

    /**
     * Retorna os dados do usuário logado.
     * 
     * @return object
     */
    public function obterUsuarioLogado() : object
    {
        return SessaoService::retornarDadosUsuarioLogado();
    }

    /**
     * Redireciona para a tela de login, caso o usuário não esteja logado.
     * @return void
     */
    public function exigirUsuarioLogado(): void
    {
        Logger::info("Verificando autenticação do usuário...");

        if(!SessaoService::usuarioLogado()){
            Logger::info("Usuário não logado! Redirecionando para a tela de login!");
            header('location: /public');
            exit;
        }
    }

    /**
     * @param array{
     * 'emailOuUsuario': string,
     * 'senhaUsuario': string
     * } $dados
     * @return void
     * @throws \DomainException
     */
    public function processaLogin(array $dados): void
    {
        Logger::info("Iniciando validação de login...");

        try {
            $entradaDados = $this->service->processaLogin($dados);

            SessaoService::salvarDadosUsuarioLogado($entradaDados);

            Logger::info("Login validado com sucesso!");

            header("location: /app/view/pagina_principal");
            exit;
        } catch (\DomainException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro($erro->getMessage());
        } 
    }
}