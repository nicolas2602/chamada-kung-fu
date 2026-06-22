<?php

namespace App\Dto\CadastroAluno;

use App\Dto\NivelFaixaDto;
use App\Dto\StatusMatriculaDto;

/**
 * @property int $idAluno;
 * @property string $nomeAluno;
 * @property string $sobrenomeAluno;
 * @property string $dataNascimento;
 * @property NivelFaixaDto $entradaNivelFaixa;
 * @property StatusMatriculaDto $entradaStatusMatricula;
 */
class CadastroAlunoDto {
    public int $idAluno;
    public string $nomeAluno;
    public string $sobrenomeAluno;
    public string $dataNascimento;
    public NivelFaixaDto $entradaNivelFaixa;
    public StatusMatriculaDto $entradaStatusMatricula;
}