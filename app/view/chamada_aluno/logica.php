<?php

use App\Controller\ChamadaAlunoController;
use App\Controller\LoginController;
use App\Helpers\FormularioHelpers;
use App\Helpers\MensagemHelpers;

$loginController = new LoginController($conexao);
$chamadaAlunoController = new ChamadaAlunoController($conexao);
$loginController->exigirUsuarioLogado();
$dadosUsuario = $loginController->obterUsuarioLogado();
$entradaChamada = $chamadaAlunoController->listarChamadaAlunos();
$chamadaAlunoController->registrarChamada();

$campos = ['statusChamada'];

if (isset($_POST['salvarChamadaAluno'])) {
    $statusChamadas = FormularioHelpers::capturarCampos($campos, $_POST);
    $chamadaAlunoController->salvarChamadaAluno($statusChamadas, $entradaChamada);
}

$entradaMensagem = MensagemHelpers::retornaMensagem() ?? [];
