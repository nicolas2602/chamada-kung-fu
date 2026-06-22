<?php

namespace App\Dto\ChamadaAluno;

use App\Dto\StatusChamadaDto;
use App\Dto\NivelFaixaDto;

/**
 * @property int $idChamadaAluno
 * @property string $nomeAluno
 * @property string $sobrenomeAluno
 * @property string $dataChamadaAluno
 * @property NivelFaixaDto $entradaNivelFaixa
 * @property StatusChamadaDto $entradaStatusChamada
 */
class ChamadaAlunoDto
{
    public int $idChamadaAluno;
    public string $nomeAluno;
    public string $sobrenomeAluno;
    public string $dataChamadaAluno;
    public NivelFaixaDto $entradaNivelFaixa;
    public StatusChamadaDto $entradaStatusChamada;
}