<?php

namespace App\Services;

use Config\Conexao;
use App\Helpers\ValidacaoHelpers;
use App\Model\LoginModel;
use App\Model\ClasseAuxiliarModel;
use App\Dto\Login\LoginCampoDto;
use App\Dto\Login\LoginDto;
use App\Dto\PerfilUsuarioDto;

/**
 * @property LoginModel $loginModel
 * @property ClasseAuxiliarModel $classeAuxiliarModel
 */
class LoginService
{
    private LoginModel $loginModel;
    private ClasseAuxiliarModel $classeAuxiliarModel;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->loginModel = new LoginModel($conexao);
        $this->classeAuxiliarModel = new ClasseAuxiliarModel($conexao);
    }

    /**
     * @param array{
     *  'emailOuUsuario': string,
     *  'senhaUsuario': string
     * } $dados
     * 
     * @return LoginCampoDto
     */
    private function converterCamposParaDto(array $dados): LoginCampoDto
    {
        $entradaDados = new LoginCampoDto();
        $entradaDados->nomeUsuario = $dados['emailOuUsuario'];
        $entradaDados->emailUsuario = $dados['emailOuUsuario'];
        $entradaDados->senhaUsuario = $dados['senhaUsuario'];
        return $entradaDados;
    }

    /**
     * @param array{
     *  'idUsuario': int,
     *  'nomeUsuario': string,
     *  'emailUsuario': string
     * } $dados
     * 
     * @param array{
     *  'idPerfil': int,
     *  'tipoPerfil': string
     * } $dadosPerfilUsuario
     * @return LoginDto
     */
    private function converterDadosParaDto(array $dados, array $dadosPerfilUsuario): LoginDto
    {
        $entradaDados = new LoginDto();
        $entradaDados->idUsuario = $dados['idUsuario'];
        $entradaDados->nomeUsuario = $dados['nomeUsuario'];
        $entradaDados->emailUsuario = $dados['emailUsuario'];

        $entradaPerfilUsuario = new PerfilUsuarioDto();
        $entradaPerfilUsuario->idPerfilUsuario = $dadosPerfilUsuario['idPerfil'];
        $entradaPerfilUsuario->tipoPerfilUsuario = $dadosPerfilUsuario['tipoPerfil'];

        $entradaDados->entradaPerfilUsuario = $entradaPerfilUsuario;

        return $entradaDados;
    }

    /**
     * @param array{
     * 'emailOuUsuario': string,
     * 'senhaUsuario': string
     * } $dados
     * @throws \DomainException
     */
    private function validacaoLogin($dados): void
    {
        $emailOuUsuarioVazio = ValidacaoHelpers::ehTextoVazio($dados['emailOuUsuario']);
        $senhaVazia = ValidacaoHelpers::ehTextoVazio($dados['senhaUsuario']);
        $ehEmailValido = ValidacaoHelpers::validaEmail($dados['emailOuUsuario']);
        $ehUsuarioValido = ValidacaoHelpers::validaUsuario($dados['emailOuUsuario']);
        $ehSenhaValida = ValidacaoHelpers::validaSenha($dados['senhaUsuario']);

        if (!$emailOuUsuarioVazio) {
            throw new \DomainException("O campo 'E-mail ou Usuário' está vazio!");
        }
        if (!$senhaVazia) {
            throw new \DomainException("O campo 'Senha' está vazio!");
        }
        if (!$ehEmailValido && !$ehUsuarioValido) {
            throw new \DomainException("O campo 'E-mail ou Usuário' está inválido!");
        }
        if (!$ehSenhaValida) {
            throw new \DomainException("O campo 'Senha' está inválido!");
        }
    }

    /**
     * Envia as informações do login e retorna os dados.
     * 
     * @param array{
     * 'emailOuUsuario': string,
     * 'senhaUsuario': string
     * } $dados
     * @return LoginDto
     * @throws \DomainException
     */
    public function processaLogin(array $dados): LoginDto
    {
        $this->validacaoLogin($dados);

        $entrada = $this->converterCamposParaDto($dados);
        $entradaDados = $this->loginModel->mostrarUsuarioLogado($entrada);

        if (!$entradaDados) {
            throw new \DomainException("E-mail, usuário ou senha inválidos!");
        }

        $idPerfil = $entradaDados['fkIdPerfil'];
        $retornaPerfilUsuario = $this->classeAuxiliarModel->mostrarPerfilUsuarioPorId($idPerfil);

        if (!$retornaPerfilUsuario) {
            throw new \DomainException("Perfis não encontrados!");
        }

        $retorno = $this->converterDadosParaDto($entradaDados, $retornaPerfilUsuario);

        return $retorno;
    }
}
