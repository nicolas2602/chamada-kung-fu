<?php

use App\Controller\LoginController;

$loginController = new LoginController($conexao);
$loginController->exigirUsuarioLogado();

$dadosUsuario = $loginController->obterUsuarioLogado();
