<?php

namespace App\Dto\CadastroAluno;

use App\Dto\CadastroAluno\CadastroAlunoDto;

/**
 * @property array<CadastroAlunoDto> $entrada
 * @property int $totalAlunos;
 */
class CadastroAlunoEntradaDto
{
    public array $entrada = [];
    public int $totalAlunos;
}