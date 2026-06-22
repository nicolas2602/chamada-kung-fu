<?php

namespace App\Dto\CadastroAluno;

/**
 * @property string $nomeAluno
 * @property string $sobrenomeAluno
 * @property string $dataNascimento
 * @property int $idNivelFaixa
 * @property int $idAluno
 * @property int $idStatusMatricula
 */
class CadastroAlunoCampoAtualizacaoDto
{
    public string $nomeAluno;
    public string $sobrenomeAluno;
    public string $dataNascimento;
    public int $idNivelFaixa;
    public int $idAluno;
    public int $idStatusMatricula;
}