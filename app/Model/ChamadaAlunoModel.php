<?php

namespace App\Model;

use Config\Conexao;
use App\Dto\ChamadaAluno\ChamadaAlunoInsereDto;
use App\Dto\ChamadaAluno\ChamadaAlunoSalvaDto;
use App\Exceptions\ChamadaAluno\ChamadaInvalidaException;
use App\Exceptions\ChamadaAluno\FalhaChamadaException;

/**
 * @property Conexao $conexao
 */
class ChamadaAlunoModel
{
    private Conexao $conexao;

    /**
     * @param Conexao $conexao
     */
    public function __construct($conexao)
    {
        $this->conexao = $conexao;
    }

    /**
     * Listar os alunos cadastrados.
     * 
     * @param string $dataChamada
     * @param int $idStatusMatricula
     * 
     * @return array{
     * 'idChamada': int,
     * 'nomePessoa': string,
     * 'sobNomePessoa': string,
     * 'dataChamada': string,
     * 'fkIdStatusChamada': int,
     * 'fkIdNivFaixa': int
     * } | false
     */
    public function listarChamadasAlunosAtivos(string $dataChamada, int $idStatusMatricula): array|false
    {
        $sql = "SELECT 
                    cp.idChamada AS idChamada,
                    ps.nomePessoa AS nomePessoa, 
                    ps.sobNomePessoa AS sobNomePessoa, 
                    cp.fkIdStatusChamada AS fkIdStatusChamada,
                    ps.fkIdNivFaixa AS fkIdNivFaixa
                FROM chamada_pessoa AS cp 
                INNER JOIN pessoa AS ps 
                ON cp.fkIdPessoa = ps.idPessoa
                WHERE cp.dataChamada = ? AND 
                    ps.fkIdStatusMat = ?
                ORDER BY
                    ps.fkIdNivFaixa DESC, 
                    ps.nomePessoa ASC,
                    ps.sobNomePessoa ASC
        ";
        $stmt = $this->conexao->executar($sql, [
            $dataChamada,
            $idStatusMatricula
        ]);

        if (!$stmt) {
            return false;
        }

        $retorno = [];

        while ($linha = $stmt->fetch_assoc()) {
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * Listar os alunos cadastrados por data.
     * 
     * @param string $dataChamada
     * 
     * @return array{
     * 'idChamada': int,
     * 'nomePessoa': string,
     * 'sobNomePessoa': string,
     * 'dataChamada': string,
     * 'fkIdStatusChamada': int,
     * 'fkIdNivFaixa': int
     * } | false
     */
    public function listarChamadasAlunosPorData(string $dataChamada): array|false
    {
        $sql = "SELECT 
                    cp.idChamada AS idChamada, 
                    ps.nomePessoa AS nomePessoa, 
                    ps.sobNomePessoa AS sobNomePessoa, 
                    cp.dataChamada AS dataChamada, 
                    cp.fkIdStatusChamada AS fkIdStatusChamada,
                    ps.fkIdNivFaixa AS fkIdNivFaixa
                FROM chamada_pessoa AS cp 
                INNER JOIN pessoa AS ps 
                ON cp.fkIdPessoa = ps.idPessoa
                WHERE cp.dataChamada = ?
                ORDER BY
                    ps.fkIdNivFaixa DESC, 
                    ps.nomePessoa ASC,
                    ps.sobNomePessoa ASC
        ";
        $stmt = $this->conexao->executar($sql, [$dataChamada]);

        if (!$stmt) {
            return false;
        }

        $retorno = [];

        while ($linha = $stmt->fetch_assoc()) {
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * @return array|false
     */
    public function retornaDatasChamadasAlunosOrdenadasEmDecrescente(): array|false
    {
        $sql = "SELECT 
                dataChamada
            FROM chamada_pessoa
            GROUP BY dataChamada
            ORDER BY dataChamada DESC
        ";

        $stmt = $this->conexao->executar($sql);

        if(!$stmt) {
            return false;
        }

        $retorno = [];

        while($linha = $stmt->fetch_assoc()) {
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * @return array|false
     */
    public function retornaQuantidadeDatasChamadas(): array|false
    {
        $sql = "SELECT 
                COUNT(DISTINCT dataChamada) as quantidadeDatasChamadas
            FROM chamada_pessoa
        ";

        $stmt = $this->conexao->executar($sql);

        if(!$stmt) {
            return false;
        }

        return $stmt->fetch_assoc();
    }

    /**
     * @param ChamadaAlunoInsereDto $entradaDados
     * @return int
     * @throws FalhaChamadaException|ChamadaInvalidaException
     */
    public function registrarChamadaAluno(ChamadaAlunoInsereDto $entradaDados): int
    {
        $sql = "INSERT INTO 
                    chamada_pessoa(
                        dataChamada, 
                        fkIdPessoa, 
                        fkIdStatusChamada
                    )
                VALUES (
                    ?,
                    ?, 
                    ?
                );
        ";

        try {
            $this->conexao->executar($sql, [
                $entradaDados->dataChamada,
                $entradaDados->fkIdPessoa,
                $entradaDados->fkIdStatusChamada
            ]);

            return $this->conexao->insertId();
        } catch (\RuntimeException $erro) {

            if ($erro->getCode() === 1062) {
                throw new ChamadaInvalidaException(
                    "A chamada deste aluno já foi registrada hoje."
                );
            }

            throw new FalhaChamadaException(
                "Erro ao registrar a chamada do aluno: " . $erro->getMessage()
            );
        }
    }

    /**
     * @param ChamadaAlunoSalvaDto $entradaDados
     * @return void
     * @throws FalhaChamadaException
     */
    public function salvarChamadaAluno(ChamadaAlunoSalvaDto $entradaDados): void
    {
        $sql = "UPDATE chamada_pessoa
                SET
                    fkIdStatusChamada = ?
                where idChamada = ?";
        
        try {
            $this->conexao->executar($sql, [
                $entradaDados->idStatusChamada,
                $entradaDados->idChamadaAluno
            ]);
        } catch (\RuntimeException $erro) {
            throw new FalhaChamadaException(
                "Erro ao salvar a chamada do aluno: " . $erro->getMessage()
            );
        }

    }
}
