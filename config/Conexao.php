<?php

namespace Config;

/**
 * @property \mysqli $conexao
 */
class Conexao
{
    private ?\mysqli $conexao = null;

    /**
     * @return \mysqli
     */
    private function conexao(): \mysqli
    {
        if ($this->conexao instanceof \mysqli) {
            return $this->conexao;
        }

        $this->conexao = new \mysqli(
            $_ENV['BANCO_ENDERECO'],
            $_ENV['BANCO_USUARIO'],
            $_ENV['BANCO_SENHA'],
            $_ENV['BANCO_NOME']
        );

        if ($this->conexao->connect_error) {
            throw new \RuntimeException("Erro ao conectar no banco: " . $this->conexao->connect_error);
        }

        return $this->conexao;
    }

    /** 
     * Verificar se o banco de dado está conectado a classe. 
     * @return bool
     */
    public function testaConexao(): bool
    {

        $conexao = $this->conexao();

        if (!$conexao) {
            return false;
        }

        return true;
    }

    /**
     * Executa uma query preparada
     * - SELECT retorna mysqli_result
     * - INSERT / UPDATE / DELETE retorna true
     *
     * @param string $sql
     * @param array $parametros
     * @return \mysqli_result|bool
     * @throws \RuntimeException
     */
    public function executar(string $sql, array $parametros = []): \mysqli_result|bool
    {
        $conexao = $this->conexao();

        /**
         * Verifica se existe o SELECT não possui parâmetros
         */
        if (count($parametros) === 0 && preg_match('/^\s*SELECT/i', $sql)) {
            $resultado = $conexao->query($sql);
            if ($resultado === false) {
                throw new \RuntimeException(
                    $conexao->error,
                    $conexao->errno
                );
            }
            return $resultado;
        }

        $stmt = $conexao->prepare($sql);
        if (!$stmt) {
            throw new \RuntimeException(
                $conexao->error,
                $conexao->errno
            );
        }

        /**
         * Verifica as tipagens dos parâmetros declarados.
         */
        if (count($parametros) !== 0) {
            $tipos = '';
            foreach ($parametros as $param) {
                $tipos .= match (true) {
                    is_int($param)   => 'i',
                    is_float($param) => 'd',
                    default          => 's',
                };
            }

            $stmt->bind_param($tipos, ...$parametros);
        }

        /**
         * Executa os dados preparados.
         */
        if (!$stmt->execute()) {
            $erro = new \RuntimeException(
                $stmt->error,
                $stmt->errno
            );
            $stmt->close();
            throw $erro;
        }

        /**
         * Retorna os dados preparados.
         */
        if (preg_match('/^\s*SELECT/i', $sql)) {
            $resultado = $stmt->get_result();
            if ($resultado === false) {
                $erro = new \RuntimeException(
                    $stmt->error,
                    $stmt->errno
                );
                $stmt->close();
                throw $erro;
            }
            return $resultado;
        }

        $stmt->close();
        return true;
    }

    /**
     * Ao inserir os dados em uma tabela, retornará o ID do registro.
     * @return int
     */
    public function insertId(): int
    {
        return (int) $this->conexao()->insert_id;
    }

    public function affectedRows(): string|int
    {
        return $this->conexao()->affected_rows;
    }

    /**
     * Inicia a transação para alterar o estado da tabela.
     * @return void
     */
    public function begin(): void
    {
        $this->conexao()->begin_transaction();
    }

    /**
     * Com a transação iniciada e o valor da tabela alterada. 
     * Salva a tabela, para não voltar no estado anterior.
     */
    public function commit(): void
    {
        $this->conexao()->commit();
    }

    /**
     * Com a transação iniciada, caso de erro ao alterar o valor da tabela,
     * volta ao estado anterior da tabela.
     */
    public function rollback(): void
    {
        $this->conexao()->rollback();
    }
}
