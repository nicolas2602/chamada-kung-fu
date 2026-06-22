<?php

namespace App\Model;

use Config\Conexao;
use App\Dto\CadastroAluno\CadastroAlunoCampoDto;
use App\Dto\CadastroAluno\CadastroAlunoCampoAtualizacaoDto;
use App\Dto\CadastroAluno\CadastroAlunoFiltroDto;
use App\Exceptions\CadastroAluno\FalhaCadastroException;

/**
 * @property Conexao $conexao
 */
class CadastroAlunoModel
{

    private Conexao $conexao;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    /**
     * @param int $idStatusMatricula
     * @return array{
     *  'idPessoa': int
     * }|false
     */
    public function retornaIdsAlunosAtivos(int $idStatusMatricula): array|false
    {
        $sql = "SELECT 
                    idPessoa 
                FROM pessoa
                WHERE fkIdStatusMat = ?;
        ";

        $stmt = $this->conexao->executar($sql, [$idStatusMatricula]);

        if(!$stmt){
            return false;
        }

        $retorno = [];

        while($linha = $stmt->fetch_assoc()){
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * @param CadastroAlunoFiltroDto $filtro
     * @return array|false
     */
    public function mostrarAlunos(CadastroAlunoFiltroDto $filtro): array|false
    {
        $sql = "SELECT 
                    ps.idPessoa AS idPessoa,
                    ps.nomePessoa AS nomePessoa,
                    ps.sobNomePessoa AS sobNomePessoa,
                    ps.dataNascimento AS dataNascimento,
                    ps.fkIdNivFaixa AS fkIdNivFaixa,
                    ps.fkIdStatusMat AS fkIdStatusMat
                FROM pessoa AS ps 
            ";

        $parametros = [];
        $condicao = [];

        if ($filtro->idNivelFaixa) {
            $parametros[] = "ps.fkIdNivFaixa = ?";
            $condicao[] = $filtro->idNivelFaixa;
        }

        if ($filtro->idStatusMatricula) {
            $parametros[] = "ps.fkIdStatusMat = ?";
            $condicao[] = $filtro->idStatusMatricula;
        }

        if (count($condicao) > 0) {
            $sql .= "\nWHERE " . implode(" AND ", $parametros);
        }

        $sql .= "\nORDER BY ps.nomePessoa, ps.sobNomePessoa ASC";
        $sql .= "\nLIMIT ?, ?";
        $condicao[] = $filtro->inicio;
        $condicao[] = $filtro->limite;

        $stmt = $this->conexao->executar($sql, $condicao);

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
     * @param CadastroAlunoFiltroDto $filtro
     * @return array{
     * 'totalAlunos': int
     * } | false
     */
    public function totalAlunos(CadastroAlunoFiltroDto $filtro): array|false
    {
        $sql = "SELECT 
                    COUNT(ps.nomePessoa) AS totalAlunos
                FROM pessoa AS ps
                INNER JOIN nivel_faixa AS nf
                ON ps.fkIdNivFaixa = nf.idNivFaixa
                INNER JOIN status_matricula AS sm
                ON ps.fkIdStatusMat = sm.idStatusMat
            ";

        $parametros = [];
        $condicao = [];

        if ($filtro->idNivelFaixa) {
            $parametros[] = "nf.idNivFaixa = ?";
            $condicao[] = $filtro->idNivelFaixa;
        }

        if ($filtro->idStatusMatricula) {
            $parametros[] = "sm.idStatusMat = ?";
            $condicao[] = $filtro->idStatusMatricula;
        }

        if (count($condicao) > 0) {
            $sql .= "\nWHERE " . implode(" AND ", $parametros);
        }

        $stmt = $this->conexao->executar($sql, $condicao);

        if (!$stmt) {
            return false;
        }

        return $stmt->fetch_assoc();
    }

    /**
     * @param CadastroAlunoCampoDto $dados
     * @return int
     * @throws FalhaCadastroException
     */
    public function cadastraAluno(CadastroAlunoCampoDto $dados): int
    {

        $sql = "INSERT INTO pessoa(
                nomePessoa,
                sobNomePessoa,
                dataNascimento,
                fkIdNivFaixa,
                fkIdStatusMat,
                fkIdUsuario
            )
            VALUES (
                ?, 
                ?,
                ?, 
                ?, 
                ?, 
                ?
            );";

        $stmt = $this->conexao->executar($sql, [
            $dados->nomeAluno,
            $dados->sobrenomeAluno,
            $dados->dataNascimento,
            $dados->idNivelFaixa,
            $dados->idStatusMatricula,
            $dados->idUsuario
        ]);

        if (!$stmt) {
            throw new FalhaCadastroException("Erro ao inserir o aluno!");
        }

        return $this->conexao->insertId();
    }

    /**
     * @param CadastroAlunoCampoAtualizacaoDto $dados
     * @return void
     * @throws FalhaCadastroException
     */
    public function atualizarAluno(CadastroAlunoCampoAtualizacaoDto $dados): void
    {

        $sql = "UPDATE pessoa 
                SET 
                    nomePessoa=?, 
                    sobNomePessoa=?, 
                    dataNascimento=?, 
                    fkIdNivFaixa=?,
                    fkIdStatusMat=?
                WHERE idPessoa=?;";

        $stmt = $this->conexao->executar($sql, [
            $dados->nomeAluno,
            $dados->sobrenomeAluno,
            $dados->dataNascimento,
            $dados->idNivelFaixa,
            $dados->idStatusMatricula,
            $dados->idAluno
        ]);

        if (!$stmt) {
            throw new FalhaCadastroException("Erro ao atualizar o aluno!");
        }
    }
}
