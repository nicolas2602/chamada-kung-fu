<?php

namespace App\Controller;

use Config\Conexao;
use App\Helpers\Logger;
use App\Helpers\MensagemHelpers;
use App\Services\CadastroAlunoService;
use App\Dto\CadastroAluno\CadastroAlunoEntradaDto;
use App\Dto\NivelFaixaDto;
use App\Dto\StatusMatriculaDto;
use App\Exceptions\CadastroAluno\CadastroInvalidoException;
use App\Exceptions\CadastroAluno\FalhaCadastroException;

/**
 * @property CadastroAlunoService $cadastroAlunoService
 */
class CadastroAlunoController
{
    private CadastroAlunoService $cadastroAlunoService;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->cadastroAlunoService = new CadastroAlunoService($conexao);
    }

    /**
     * Retorna os níveis das faixas.
     * 
     * @return array<NivelFaixaDto>
     */
    public function mostrarNivelFaixa(): array
    {
        return $this->cadastroAlunoService->mostrarNivelFaixa();
    }

    /**
     * Retorna os status da matrícula.
     * 
     * @return array<StatusMatriculaDto>
     */
    public function mostrarStatusMatricula(): array
    {
        return $this->cadastroAlunoService->mostrarStatusMatricula();
    }

    /**
     * Retorna os dados dos alunos.
     * @param array{
     * 'nivelFaixa': string,
     * 'statusMatricula': string
     * } $filtro
     * @param int $limitePaginacao
     * @return CadastroAlunoEntradaDto|false
     */
    public function mostrarDadosAlunos(array $filtro, int $limitePaginacao): CadastroAlunoEntradaDto|false 
    {
        return $this->cadastroAlunoService->mostrarDadosAlunos($filtro, $limitePaginacao);
    }

    /**
     * Registra os dados fornecidos do aluno.
     * 
     * @param array $campos
     * @param object $dadosUsuario
     * @return void
     * @throws CadastroInvalidoException|FalhaCadastroException
     */
    public function processaCadastroAluno(array $campos, object $dadosUsuario): void
    {
        try {
            $idAluno = $this->cadastroAlunoService->processaCadastroAluno(
                $campos,
                $dadosUsuario
            );

            Logger::info("Novo aluno cadastrado com sucesso! ID: " . $idAluno);

            MensagemHelpers::sucesso("Novo aluno cadastrado com sucesso!");

            header("location: /app/view/cadastro_aluno");
            exit;
        } catch (CadastroInvalidoException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro($erro->getMessage());
        } catch (FalhaCadastroException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro("Ocorreu um erro ao cadastrar! Por favor, entre em contato com o administrador do sistema!");
        }
    }

    /**
     * Atualiza os dados fornecidos do aluno.
     * 
     * @param array $campos
     * @return void
     * @throws CadastroInvalidoException|FalhaCadastroException
     */
    public function atualizaCadastroAluno(array $campos): void
    {
        try {
            $this->cadastroAlunoService->atualizaCadastroAluno($campos);

            Logger::info("Dados do aluno atualizado com sucesso!");

            MensagemHelpers::sucesso("Dados do aluno atualizado com sucesso!");

            header("location: /app/view/cadastro_aluno");
            exit;
        } catch (CadastroInvalidoException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro($erro->getMessage());
        } catch (FalhaCadastroException $erro) {
            Logger::error($erro->getMessage());
            MensagemHelpers::erro("Ocorreu um erro ao cadastrar! Por favor, entre em contato com o administrador do sistema!");
        }
    }
}
