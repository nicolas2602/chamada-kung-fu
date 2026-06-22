<?php

use App\Controller\LoginController;
use App\Helpers\FormularioHelpers;
use App\Helpers\MensagemHelpers;

$campos = [
    'emailOuUsuario',
    'senhaUsuario'
];

if (isset($_POST['loginUsuario'])) {
    
    $loginController = new LoginController($conexao);

    $dados = FormularioHelpers::capturarCampos($campos, $_POST);

    $loginController->processaLogin($dados);
}

$entradaMensagem = MensagemHelpers::retornaMensagem() ?? [];
