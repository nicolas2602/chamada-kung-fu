<?php

namespace App\Model;

use Config\Conexao;
use App\Dto\CadastroAluno\CadastroAlunoFiltroDto;

/**
 * @property Conexao $conexao
 */
class ClasseAuxiliarModel {
    private Conexao $conexao;

    /**
     * @param Conexao $conexao
     */
    public function __construct(Conexao $conexao){
        $this->conexao = $conexao;
    }

    public function begin()
    {
        $this->conexao->begin();
    }

    public function commit()
    {
        $this->conexao->commit();
    }

    public function rollback()
    {
        $this->conexao->rollback();
    }

    /**
     * @param int $id
     * @return array{
     *  'idPerfil': int,
     *  'tipoPerfil': string
     * } | false
     */
    public function mostrarPerfilUsuarioPorId(int $id) : array|false
    {
        $sql = "SELECT 
                    idPerfil,
                    tipoPerfil
                FROM perfil
                WHERE idPerfil = ?
            ";
        
        $stmt = $this->conexao->executar($sql, [$id]);

        if(!$stmt){
            return false;
        }

        return $stmt->fetch_assoc();
    }

    /**
     * @return array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } | false
     */
    public function mostrarNivelFaixa() : array|false
    {
        $sql = "SELECT 
                    idNivFaixa,
                    tipoNivFaixa
                FROM nivel_faixa
            ";
        
        $stmt = $this->conexao->executar($sql);

        if(!$stmt){
            return false;
        }

        $retorno = [];

        while ($linha = $stmt->fetch_assoc()){
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * @param int $id
     * @return array{
     *  'idNivFaixa': int,
     *  'tipoNivFaixa': string
     * } | false
     */
    public function mostrarNivelFaixaPorId(int $id) : array|false
    {
        $sql = "SELECT 
                    idNivFaixa,
                    tipoNivFaixa
                FROM nivel_faixa
                WHERE idNivFaixa = ?
            ";

        $stmt = $this->conexao->executar($sql, [$id]);

        if(!$stmt){
            return false;
        }

        $resultado = $stmt->fetch_assoc();

        if (!$resultado) {
            return false;
        }

        return $resultado;
    }

    /**
     * @return array{
     *  'idStatusMat': int,
     *  'statusMat': string
     * }|false
     */
    public function mostrarStatusMatricula() : array|false
    {
        $sql = "SELECT 
                    idStatusMat,
                    statusMat
                FROM status_matricula
            ";

        $stmt = $this->conexao->executar($sql);

        if(!$stmt){
            return false;
        }

        $retorno = [];

        while ($linha = $stmt->fetch_assoc()){
            $retorno[] = $linha;
        }

        return $retorno;
    }

        /**
     * @param int $id
     * @return array{
     *  'idStatusMat': int,
     *  'statusMat': string
     * } | false
     */
    public function mostrarStatusMatriculaPorId(int $id) : array|false
    {
        $sql = "SELECT 
                    idStatusMat,
                    statusMat
                FROM status_matricula
                WHERE idStatusMat = ?
            ";

        $stmt = $this->conexao->executar($sql, [$id]);

        if(!$stmt){
            return false;
        }

        $resultado = $stmt->fetch_assoc();

        if (!$resultado) {
            return false;
        }

        return $resultado;
    }

    /**
     * @return array{
     *  'idStatusChamada': int,
     *  'tipoStatusChamada': string
     * } | false
     */
    public function mostrarStatusChamada() : array|false
    {
        $sql = "SELECT 
                    idStatusChamada,
                    tipoStatusChamada
                FROM status_chamada
            ";
        
        $stmt = $this->conexao->executar($sql);

        if(!$stmt){
            return false;
        }

        $retorno = [];

        while ($linha = $stmt->fetch_assoc()){
            $retorno[] = $linha;
        }

        return $retorno;
    }

    /**
     * @param int $id
     * @return array{
     *  'idStatusChamada': int,
     *  'tipoStatusChamada': string
     * } | false
     */
    public function mostrarStatusChamadaPorId(int $id) : array|false
    {
        $sql = "SELECT 
                    idStatusChamada,
                    tipoStatusChamada
                FROM status_chamada
                WHERE idStatusChamada = ?
            ";
        
        $stmt = $this->conexao->executar($sql, [$id]);

        if(!$stmt){
            return false;
        }

        $resultado = $stmt->fetch_assoc();

        if (!$resultado) {
            return false;
        }

        return $resultado;
    }
}