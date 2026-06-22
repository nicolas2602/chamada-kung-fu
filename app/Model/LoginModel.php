<?php

namespace App\Model;

use Config\Conexao;
use App\Dto\Login\LoginCampoDto;

/**
 * @property Conexao $conexao
 */
class LoginModel
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
     * @param LoginCampoDto $dados
     * @return array{
     *  'idUsuario': int,
     *  'nomeUsuario': string,
     *  'emailUsuario': string,
     *  'fkIdPerfil': int
     * }|false
     */
    public function mostrarUsuarioLogado(LoginCampoDto $dados): array|false
    {
        $sql = "SELECT 
                    idUsuario, 
                    nomeUsuario,
                    emailUsuario,
                    fkIdPerfil
                FROM usuario
                WHERE 
                    (
                        nomeUsuario=? OR 
                        emailUsuario=?
                    ) AND
                    senhaUsuario=?";
        $stmt = $this->conexao->executar($sql, [
            $dados->nomeUsuario,
            $dados->emailUsuario,
            $dados->senhaUsuario
        ]);

        if (!$stmt) {
            return false;
        }

        $resultado = $stmt->fetch_assoc();

        if (!$resultado) {
            return false;
        }

        return $resultado;
    }
}
