<?php

namespace App\Dto\ChamadaAluno;

/**
 * @property string $dataChamada
 * @property int $fkIdPessoa
 * @property int $fkIdStatusChamada
 */
class ChamadaAlunoInsereDto
{
    public string $dataChamada;
    public int $fkIdPessoa;
    public int $fkIdStatusChamada;
}