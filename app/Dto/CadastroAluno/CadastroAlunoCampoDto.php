<?php

namespace App\Dto\CadastroAluno;

/**
 * @property string $nomeAluno
 * @property string $sobrenomeAluno
 * @property string $dataNascimento
 * @property int $idNivelFaixa
 * @property int $idStatusMatricula
 * @property int $idUsuario
 */
class CadastroAlunoCampoDto
{
    public string $nomeAluno;
    public string $sobrenomeAluno;
    public string $dataNascimento;
    public int $idNivelFaixa;
    public int $idStatusMatricula;
    public int $idUsuario;
}