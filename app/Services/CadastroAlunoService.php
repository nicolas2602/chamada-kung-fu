<?php

namespace App\Services;

use Config\Conexao;
use App\Helpers\PaginacaoHelpers;
use App\Helpers\Logger;
use App\Helpers\ValidacaoHelpers;
use App\Model\ClasseAuxiliarModel;
use App\Model\CadastroAlunoModel;
use App\Dto\CadastroAluno\CadastroAlunoEntradaDto;
use App\Dto\CadastroAluno\CadastroAlunoCampoDto;
use App\Dto\CadastroAluno\CadastroAlunoCampoAtualizacaoDto;
use App\Dto\CadastroAluno\CadastroAlunoDto;
use App\Dto\CadastroAluno\CadastroAlunoFiltroDto;
use App\Dto\NivelFaixaDto;
use App\Dto\StatusMatriculaDto;
use App\Exceptions\CadastroAluno\CadastroInvalidoException;
use App\Exceptions\CadastroAluno\FalhaCadastroException;

/**
 * @property CadastroAlunoModel $cadastroAlunoModel
 * @property ClasseAuxiliarModel $classeAuxiliarModel
 */
class CadastroAlunoService
{
    private CadastroAlunoModel $cadastroAlunoModel;
    private ClasseAuxiliarModel $classeAuxiliarModel;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->cadastroAlunoModel = new CadastroAlunoModel($conexao);
        $this->classeAuxiliarModel = new ClasseAuxiliarModel($conexao);
    }

    /**
     * @param array{
     *  'nomeAluno': string,
     *  'sobrenomeAluno': string,
     *  'dataNascimento': string,
     *  'nivelFaixa': string
     * } $dados
     * @return void
     * @throws CadastroInvalidoException
     */
    private function validarCadastroAluno($dados): void
    {
        if (!ValidacaoHelpers::ehTextoVazio($dados['nomeAluno'])) {
            throw new CadastroInvalidoException("O campo 'Nome' está vazio!");
        }
        if (!ValidacaoHelpers::ehTextoVazio($dados['sobrenomeAluno'])) {
            throw new CadastroInvalidoException("O campo 'Sobrenome' está vazio!");
        }
        if (!ValidacaoHelpers::ehTextoVazio($dados['dataNascimento'])) {
            throw new CadastroInvalidoException("O campo 'Data de Nascimento' não está selecionado!");
        }
        if (!ValidacaoHelpers::ehTextoVazio($dados['nivelFaixa'])) {
            throw new CadastroInvalidoException("O campo 'Nível da faixa' não está selecionado!");
        }
    }

    /**
     * @param array{
     * 'nomeAluno': string,
     * 'sobrenomeAluno': string,
     * 'dataNascimento': string,
     * 'nivelFaixa': string,
     * 'idAluno': string,
     * 'statusMatricula': string
     * } $dados
     * @return void
     * @throws CadastroInvalidoException
     */
    private function validarAtualizacaoAluno($dados): void
    {
        $this->validarCadastroAluno($dados);

        if (!ValidacaoHelpers::ehTextoVazio($dados['idAluno'])) {
            throw new CadastroInvalidoException("O campo 'ID' está vazio!");
        }
        if (!ValidacaoHelpers::ehTextoVazio($dados['statusMatricula'])) {
            throw new CadastroInvalidoException("O campo 'Status da matrícula' não está selecionado!");
        }
    }

    /**
     * @param array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } $dadosNivelFaixa
     * 
     * @return NivelFaixaDto
     */
    private function converterNivelFaixaParaDto(array $dadosNivelFaixa): NivelFaixaDto
    {
        $entradaNivelFaixa = new NivelFaixaDto();
        $entradaNivelFaixa->idNivelFaixa = (int) ($dadosNivelFaixa['idNivFaixa'] ?? 0);
        $entradaNivelFaixa->nivelFaixa = $dadosNivelFaixa['tipoNivFaixa'] ?? '';

        return $entradaNivelFaixa;
    }

    /**
     * @param array{
     *  'idStatusMat': int,
     *  'statusMat': string
     * } $dadosStatusMatricula
     * 
     * @return StatusMatriculaDto
     */
    private function converterStatusMatriculaParaDto(
        array $dadosStatusMatricula
    ): StatusMatriculaDto {
        $entradaStatusMatricula = new StatusMatriculaDto();
        $entradaStatusMatricula->idStatusMatricula = (int) ($dadosStatusMatricula['idStatusMat'] ?? 0);
        $entradaStatusMatricula->statusMatricula = $dadosStatusMatricula['statusMat'] ?? '';

        return $entradaStatusMatricula;
    }

    /**
     * @param array{
     * 'nomeAluno': string,
     * 'sobrenomeAluno': string,
     * 'dataNascimento': string,
     * 'nivelFaixa': string
     * } $dados
     * @param object $dadosUsuario
     * 
     * @return CadastroAlunoCampoDto
     */
    private function converterCamposParaDto(
        array &$dados,
        object $dadosUsuario
    ): CadastroAlunoCampoDto {
        $entradaDados = new CadastroAlunoCampoDto();
        $entradaDados->nomeAluno = $dados['nomeAluno'] ?? '';
        $entradaDados->sobrenomeAluno = $dados['sobrenomeAluno'] ?? '';
        $entradaDados->dataNascimento = $dados['dataNascimento'] ?? '';
        $entradaDados->idNivelFaixa = (int) ($dados['nivelFaixa'] ?? 0);
        $entradaDados->idStatusMatricula = 1;
        $entradaDados->idUsuario = $dadosUsuario->idUsuario ?? 0;

        return $entradaDados;
    }

    /**
     * @param array{
     * 'nomeAluno': string,
     * 'sobrenomeAluno': string,
     * 'dataNascimento': string,
     * 'nivelFaixa': string,
     * 'idAluno': string,
     * 'statusMatricula': string
     * } $dados
     * 
     * @return CadastroAlunoCampoAtualizacaoDto
     */
    private function converterCamposAtualizacaoParaDto(
        array $dados
    ): CadastroAlunoCampoAtualizacaoDto {
        $entradaDados = new CadastroAlunoCampoAtualizacaoDto();
        $entradaDados->nomeAluno = $dados['nomeAluno'] ?? '';
        $entradaDados->sobrenomeAluno = $dados['sobrenomeAluno'] ?? '';
        $entradaDados->dataNascimento = $dados['dataNascimento'] ?? '';
        $entradaDados->idNivelFaixa = (int) ($dados['nivelFaixa'] ?? 0);
        $entradaDados->idAluno = (int) ($dados['idAluno'] ?? 0);
        $entradaDados->idStatusMatricula = (int) ($dados['statusMatricula'] ?? 0);

        return $entradaDados;
    }

    /**
     * @param array{
     * 'idPessoa': int
     * 'nomePessoa': string,
     * 'sobNomePessoa': string,
     * 'dataNascimento': string
     * } $dados
     * 
     * @param array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } $dadosNivelFaixa
     * 
     * @param array{
     *  'idStatusMat': int,
     *  'statusMat': string
     * } $dadosStatusMatricula
     * 
     * 
     * @return CadastroAlunoDto
     */
    private function converterDadosParaDto(
        array $dados,
        array $dadosNivelFaixa,
        array $dadosStatusMatricula
    ): CadastroAlunoDto {
        $entradaDados = new CadastroAlunoDto();
        $entradaDados->idAluno = $dados['idPessoa'] ?? 0;
        $entradaDados->nomeAluno = $dados['nomePessoa'] ?? '';
        $entradaDados->sobrenomeAluno = $dados['sobNomePessoa'] ?? '';
        $entradaDados->dataNascimento = $dados['dataNascimento'] ?? '';
        $entradaDados->entradaNivelFaixa = $this->converterNivelFaixaParaDto($dadosNivelFaixa);
        $entradaDados->entradaStatusMatricula = $this->converterStatusMatriculaParaDto(
            $dadosStatusMatricula
        );

        return $entradaDados;
    }

    /**
     * @param array{
     * 'nivelFaixa': string,
     * 'statusMatricula': string
     * } $filtro
     * @param int $limitePaginacao
     * 
     * @return CadastroAlunoFiltroDto
     */
    private function converterCamposFiltrosParaDto(
        array $filtro,
        int $limitePaginacao
    ): CadastroAlunoFiltroDto {
        $entradaFiltro = new CadastroAlunoFiltroDto();
        $entradaFiltro->idNivelFaixa = (int) ($filtro['nivelFaixa'] ?? 0);
        $entradaFiltro->idStatusMatricula = (int) ($filtro['statusMatricula'] ?? 0);
        $entradaFiltro->limite = $limitePaginacao;
        $entradaFiltro->inicio = PaginacaoHelpers::calculaInicioPaginacao($entradaFiltro->limite);

        return $entradaFiltro;
    }

    /**
     * 
     * Retorna os níveis das faixas.
     * 
     * @return array<NivelFaixaDto>|false
     */
    public function mostrarNivelFaixa(): array|false
    {
        $dados = $this->classeAuxiliarModel->mostrarNivelFaixa();

        if (!$dados) {
            Logger::error("Não foi possível exibir os dados. Linha: " . __LINE__);
            return false;
        }

        $retorno = [];

        foreach ($dados as $dado) {
            $retorno[] = $this->converterNivelFaixaParaDto((array) $dado);
        }

        Logger::info("Dados coletados: " . print_r($retorno, true));
        return $retorno;
    }

    /**
     * 
     * Retorna os status da matrícula.
     * 
     * @return array<StatusMatriculaDto>|false
     */
    public function mostrarStatusMatricula(): array|false
    {
        $dados = $this->classeAuxiliarModel->mostrarStatusMatricula();

        if (!$dados) {
            Logger::error("Não foi possível exibir os dados. Linha: " . __LINE__);
            return false;
        }

        $retorno = [];

        foreach ($dados as $dado) {
            $retorno[] = $this->converterStatusMatriculaParaDto((array) $dado);
        }

        Logger::info("Dados retornados: " . print_r($retorno, true));
        return $retorno;
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
    public function mostrarDadosAlunos(
        array $filtro,
        int $limitePaginacao
    ): CadastroAlunoEntradaDto|false {
        $entradaFiltro = $this->converterCamposFiltrosParaDto(
            $filtro,
            $limitePaginacao
        );

        $dadosAlunos = $this->cadastroAlunoModel->mostrarAlunos($entradaFiltro);

        if (!$dadosAlunos) {
            Logger::error("Não foi possível exibir os dados. Linha: " . __LINE__);
            return false;
        }

        $entradaCadastroAluno = new CadastroAlunoEntradaDto();

        foreach ($dadosAlunos as $dadosAluno) {
            
            $dadosNivelFaixa = $this->classeAuxiliarModel->mostrarNivelFaixaPorId(
                $dadosAluno['fkIdNivFaixa']
            );

            $dadosStatusMatricula = $this->classeAuxiliarModel->mostrarStatusMatriculaPorId(
                $dadosAluno['fkIdStatusMat']
            );

            $entradaCadastroAluno->entrada[] = $this->converterDadosParaDto(
                $dadosAluno,
                $dadosNivelFaixa,
                $dadosStatusMatricula
            );
        }

        $coletaTotalAlunos = $this->cadastroAlunoModel->totalAlunos($entradaFiltro);

        if (!$coletaTotalAlunos) {
            Logger::error("Não foi possível exibir o total. Linha: " . __LINE__);
            return false;
        }

        $entradaCadastroAluno->totalAlunos = $coletaTotalAlunos['totalAlunos'];

        Logger::info("Dados retornados: " . print_r($entradaCadastroAluno->entrada, true));
        return $entradaCadastroAluno;
    }

    /**
     * 
     * Registra os dados fornecidos do aluno.
     * 
     * @param array{
     *  'nomeAluno': string,
     *  'sobrenomeAluno': string,
     *  'dataNascimento': string,
     *  'nivelFaixa': string
     * } $campos
     * @param object $dadosUsuario
     * @return int
     * @throws CadastroInvalidoException|FalhaCadastroException
     */
    public function processaCadastroAluno(
        array $campos,
        object $dadosUsuario
    ): int {
        Logger::info("Tranferindo os dados...");

        $this->validarCadastroAluno($campos);

        $entrada = $this->converterCamposParaDto($campos, $dadosUsuario);

        $this->classeAuxiliarModel->begin();

        try {
            $cadastraAluno = $this->cadastroAlunoModel->cadastraAluno($entrada);

            Logger::info("Dados inseridos!");

            $this->classeAuxiliarModel->commit();

            return $cadastraAluno;
        } catch (FalhaCadastroException $erro) {
            $this->classeAuxiliarModel->rollback();
            throw $erro;
        }
    }

    /**
     * 
     * Atualiza os dados fornecidos do aluno.
     * 
     * @param array{
     * 'nomeAluno': string,
     * 'sobrenomeAluno': string,
     * 'dataNascimento': string,
     * 'nivelFaixa': string,
     * 'idAluno': string,
     * 'statusMatricula': string
     * } $campos
     * @return bool
     * @throws CadastroInvalidoException|FalhaCadastroException
     */
    public function atualizaCadastroAluno(array $campos): void
    {
        Logger::info("Tranferindo os dados...");

        $this->validarAtualizacaoAluno($campos);

        Logger::info("Campos validados com sucesso!");

        $this->classeAuxiliarModel->begin();

        try {
            $entrada = $this->converterCamposAtualizacaoParaDto($campos);

            $this->cadastroAlunoModel->atualizarAluno($entrada);

            $this->classeAuxiliarModel->commit();
        } catch (FalhaCadastroException $erro) {
            $this->classeAuxiliarModel->rollback();
            throw $erro;
        }
    }
}
