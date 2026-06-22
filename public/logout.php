<?php

use Config\Conexao;
use App\Controller\LoginController;

require_once("../bootstrap.php");

$conexao = new Conexao();
if (!$conexao->testaConexao()) {
    echo "<h1>Erro no banco de dados!</h1>";
    exit;
}

$login = new LoginController($conexao);
$login->logout();