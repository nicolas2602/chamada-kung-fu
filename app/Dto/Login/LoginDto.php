<?php

namespace App\Dto\Login;

use App\Dto\PerfilUsuarioDto;

/**
 * @property int $idUsuario
 * @property string $nomeUsuario
 * @property string $emailUsuario
 * @property PerfilUsuarioDto $entradaPerfilUsuario
 */
class LoginDto
{
    public int $idUsuario;
    public string $nomeUsuario;
    public string $emailUsuario;
    public PerfilUsuarioDto $entradaPerfilUsuario;
}