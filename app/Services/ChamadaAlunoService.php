<?php

namespace App\Services;

use Config\Conexao;
use App\Model\ChamadaAlunoModel;
use App\Model\CadastroAlunoModel;
use App\Model\ClasseAuxiliarModel;
use App\Dto\ChamadaAluno\ChamadaAlunoDto;
use App\Dto\ChamadaAluno\ChamadaAlunoInsereDto;
use App\Dto\ChamadaAluno\ChamadaAlunoSalvaDto;
use App\Dto\HistoricoChamadaAluno\HistoricoChamadaAlunoDto;
use App\Dto\HistoricoChamadaAluno\HistoricoChamadaAlunoEntradaDto;
use App\Dto\HistoricoChamadaAluno\HistoricoChamadaAlunoPorDataDto;
use App\Dto\NivelFaixaDto;
use App\Dto\StatusChamadaDto;
use App\Exceptions\ChamadaAluno\FalhaChamadaException;
use App\Exceptions\ChamadaAluno\ChamadaInvalidaException;
use App\Helpers\FormularioHelpers;
use App\Helpers\Logger;

/**
 * @property ChamadaAlunoModel $chamadaAlunoModel
 * @property ClasseAuxiliarModel $classeAuxiliarModel
 */
class ChamadaAlunoService
{
    private ChamadaAlunoModel $chamadaAlunoModel;
    private CadastroAlunoModel $cadastroAlunoModel;
    private ClasseAuxiliarModel $classeAuxiliarModel;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->chamadaAlunoModel = new ChamadaAlunoModel($conexao);
        $this->cadastroAlunoModel = new CadastroAlunoModel($conexao);
        $this->classeAuxiliarModel = new ClasseAuxiliarModel($conexao);
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
        $entradaNivelFaixa->idNivelFaixa = $dadosNivelFaixa['idNivFaixa'] ?? 0;
        $entradaNivelFaixa->nivelFaixa = $dadosNivelFaixa['tipoNivFaixa'] ?? '';

        return $entradaNivelFaixa;
    }

    /**
     * @param array{
     *  'idStatusChamada': int,
     *  'tipoStatusChamada': string
     * } $dadosStatusChamada
     * 
     * @return StatusChamadaDto
     */
    private function converterStatusChamadaParaDto(array $dadosStatusChamada): StatusChamadaDto
    {
        $entradaStatusChamada = new StatusChamadaDto();
        $entradaStatusChamada->idStatusChamada = $dadosStatusChamada['idStatusChamada'] ?? 0;
        $entradaStatusChamada->tipoStatusChamada = $dadosStatusChamada['tipoStatusChamada'] ?? '';

        return $entradaStatusChamada;
    }

    /**
     * @param array{
     * 'idChamada': int,
     * 'nomePessoa': string,
     * 'sobNomePessoa': string,
     * 'dataChamada': string,
     * 'fkIdStatusChamada': int,
     * 'fkIdNivFaixa': int
     * } $dadosChamada
     * 
     * @param array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } $dadosNivelFaixa
     * 
     * @param array{
     *  'idStatusChamada': int,
     *  'tipoStatusChamada': string
     * } $dadosStatusChamada
     * 
     * @return ChamadaAlunoDto
     */
    private function converterDadosParaDto(array $dadosChamada, array $dadosNivelFaixa, array $dadosStatusChamada): ChamadaAlunoDto
    {
        $entradaDados = new ChamadaAlunoDto();
        $entradaDados->idChamadaAluno = $dadosChamada['idChamada'] ?? 0;
        $entradaDados->nomeAluno = $dadosChamada['nomePessoa'] ?? '';
        $entradaDados->sobrenomeAluno = $dadosChamada['sobNomePessoa'] ?? '';
        $entradaDados->dataChamadaAluno = $dadosChamada['dataChamada'] ?? '';
        $entradaDados->entradaNivelFaixa = $this->converterNivelFaixaParaDto($dadosNivelFaixa);
        $entradaDados->entradaStatusChamada = $this->converterStatusChamadaParaDto($dadosStatusChamada);

        return $entradaDados;
    }

    /**
     * @param int $idsAlunos
     * 
     * @return ChamadaAlunoInsereDto
     */
    private function converterDadosInseridosParaDto(int $idsAlunos, int $timestamp): ChamadaAlunoInsereDto
    {
        $entradaDados = new ChamadaAlunoInsereDto();
        $entradaDados->dataChamada = FormularioHelpers::converterTimestampParaData($timestamp, "Y-m-d");
        $entradaDados->fkIdPessoa = $idsAlunos;
        $entradaDados->fkIdStatusChamada = 3;

        return $entradaDados;
    }

    /**
     * @param int $idChamadaAluno
     * @param int $statusChamada
     * @return ChamadaAlunoSalvaDto
     */
    private function converterDadosAtualizadosParaDto(int $idChamadaAluno, int $statusChamada): ChamadaAlunoSalvaDto
    {
        $entradaDados = new ChamadaAlunoSalvaDto();
        $entradaDados->idChamadaAluno = $idChamadaAluno;
        $entradaDados->idStatusChamada = $statusChamada;
        return $entradaDados;
    }

    /**
     * @param array{
     * 'nomePessoa': string,
     * 'sobNomePessoa': string,
     * 'fkIdStatusChamada': int,
     * 'fkIdNivFaixa': int
     * } $dadosChamada
     * 
     * @param array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } $dadosNivelFaixa
     * 
     * @param array{
     *  'idStatusChamada': int,
     *  'tipoStatusChamada': string
     * } $dadosStatusChamada
     * 
     * @return HistoricoChamadaAlunoDto
     */
    private function converterDadosHistoricoChamadaAlunosParaDto(array $dadosChamada, array $dadosNivelFaixa, array $dadosStatusChamada): HistoricoChamadaAlunoDto
    {
        $entradaDados = new HistoricoChamadaAlunoDto;
        $entradaDados->nomeAluno = $dadosChamada['nomePessoa'];
        $entradaDados->sobrenomeAluno = $dadosChamada['sobNomePessoa'];
        $entradaDados->nivelFaixa = $dadosNivelFaixa['tipoNivFaixa'];
        $entradaDados->statusChamada = $dadosStatusChamada['tipoStatusChamada'];
        return $entradaDados;
    }

    /**
     * @return array<ChamadaAlunoDto>
     */
    public function listarChamadaAlunos(): array
    {
        $dataChamada = FormularioHelpers::converterTimestampParaData(time(), "Y-m-d");
        $idStatusMatricula = 1;
        $dadosChamadas = $this->chamadaAlunoModel->listarChamadasAlunosAtivos($dataChamada, $idStatusMatricula);

        $retorno = [];

        foreach ($dadosChamadas as $dadosChamada) {

            $dadosNivelFaixa = $this->classeAuxiliarModel->mostrarNivelFaixaPorId($dadosChamada['fkIdNivFaixa']);

            $dadosStatusChamada = $this->classeAuxiliarModel->mostrarStatusChamadaPorId($dadosChamada['fkIdStatusChamada']);

            $retorno[] = $this->converterDadosParaDto((array)$dadosChamada, $dadosNivelFaixa, $dadosStatusChamada);
        }

        return $retorno;
    }

    /**
     * @return HistoricoChamadaAlunoEntradaDto
     */
    public function listarHistoricoChamadaAlunos(): HistoricoChamadaAlunoEntradaDto
    {
        $retornoDataChamadas = $this->chamadaAlunoModel->retornaDatasChamadasAlunosOrdenadasEmDecrescente();

        $retorno = [];

        foreach ($retornoDataChamadas as $retornoDataChamada) {
            $retornoChamadaAlunos = $this->chamadaAlunoModel->listarChamadasAlunosPorData($retornoDataChamada['dataChamada']);

            $entradaDados = new HistoricoChamadaAlunoPorDataDto();
            $entradaDados->dataChamadaAluno = $retornoDataChamada['dataChamada'];

            foreach ($retornoChamadaAlunos as $retornoChamadaAluno) {
                $dadosNivelFaixa = $this->classeAuxiliarModel->mostrarNivelFaixaPorId($retornoChamadaAluno['fkIdNivFaixa']);
                $dadosStatusChamada = $this->classeAuxiliarModel->mostrarStatusChamadaPorId($retornoChamadaAluno['fkIdStatusChamada']);

                $entradaDados->entrada[] = $this->converterDadosHistoricoChamadaAlunosParaDto(
                    (array)$retornoChamadaAluno,
                    $dadosNivelFaixa,
                    $dadosStatusChamada
                );
            }

            $retorno[] = $entradaDados;
        }

        $retornoTotalHistoricoChamada = $this->chamadaAlunoModel->retornaQuantidadeDatasChamadas();

        $entradaDadosHistoricoChamada = new HistoricoChamadaAlunoEntradaDto();
        $entradaDadosHistoricoChamada->entrada = $retorno;
        $entradaDadosHistoricoChamada->totalHistoricoChamadas = $retornoTotalHistoricoChamada['quantidadeDatasChamadas'];

        return $entradaDadosHistoricoChamada;
    }

    /**
     * @return void
     * @throws ChamadaInvalidaException|FalhaChamadaException
     */
    public function registrarChamadaAluno(): void
    {
        $retornoIdsAlunosAtivos = $this->cadastroAlunoModel->retornaIdsAlunosAtivos(1);
        $quantidadeAlunosAtivos = count($retornoIdsAlunosAtivos);

        if ($quantidadeAlunosAtivos === 0) {
            throw new ChamadaInvalidaException("Não há alunos ativos!");
        }

        $diaSemana = (int) FormularioHelpers::retornaDiaSemana(time());

        if ($diaSemana !== 2 && $diaSemana !== 4) {
            throw new ChamadaInvalidaException("Não há treino hoje! Por favor, aguarde em breve!");
        }

        $this->classeAuxiliarModel->begin();

        try {
            foreach ($retornoIdsAlunosAtivos as $retornoIdAlunoAtivo) {
                Logger::info("Iniciando o cadastro de chamada...");
                $entradaDadosRegistros = $this->converterDadosInseridosParaDto($retornoIdAlunoAtivo['idPessoa'], time());
                $idsChamadas = $this->chamadaAlunoModel->registrarChamadaAluno($entradaDadosRegistros);
                Logger::info("Nova chamada cadastrada! ID: " . $idsChamadas);
            }

            $this->classeAuxiliarModel->commit();
        } catch (FalhaChamadaException $erro) {
            $this->classeAuxiliarModel->rollback();
            throw $erro;
        } catch (ChamadaInvalidaException $erro) {
            $this->classeAuxiliarModel->rollback();
            throw $erro;
        }
    }

    /**
     * @param array{
     *  'statusChamada': array<string>
     * } $campo
     * @param array<ChamadaAlunoDto> $entradaChamada
     * @return void
     * @throws ChamadaInvalidaException|FalhaChamadaException
     */
    public function salvarChamadaAluno($campo, $entradaChamada): void
    {
        if (count($campo) === 0) {
            throw new ChamadaInvalidaException("Nenhum campo está selecionado!");
        }

        try {
            foreach ($entradaChamada as $umaChamada) {
                $id = $umaChamada->idChamadaAluno;
                $statusChamada = isset($campo['statusChamada'][$id]) ? 1 : 2;
                $entradaDados = $this->converterDadosAtualizadosParaDto($id, $statusChamada);
                Logger::info(print_r($entradaDados, true));
                $this->chamadaAlunoModel->salvarChamadaAluno($entradaDados);
                Logger::info("Chamada atualizada com sucesso!");
            }
        } catch (FalhaChamadaException $erro) {
            throw $erro;
        }
    }
}
