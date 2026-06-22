<?php

namespace App\Dto\CadastroAluno;

use App\Dto\PaginacaoDto;

/**
 * @property int $idNivelFaixa
 * @property int $idStatusMatricula
 */
class CadastroAlunoFiltroDto extends PaginacaoDto{
    public int $idNivelFaixa;
    public int $idStatusMatricula;
}