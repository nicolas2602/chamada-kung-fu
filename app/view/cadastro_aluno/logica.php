<?php

use App\Controller\LoginController;
use App\Controller\CadastroAlunoController;
use App\Helpers\FormularioHelpers;
use App\Helpers\MensagemHelpers;

$loginController = new LoginController($conexao);
$loginController->exigirUsuarioLogado();

$cadastroAlunoController = new CadastroAlunoController($conexao);
$niveisFaixas = $cadastroAlunoController->mostrarNivelFaixa();
$statusMatricula = $cadastroAlunoController->mostrarStatusMatricula();
$dadosUsuario = $loginController->obterUsuarioLogado();

$campos = [
    'nomeAluno',
    'sobrenomeAluno',
    'dataNascimento',
    'nivelFaixa'
];

if (isset($_POST['cadastraAluno'])) {
    $camposPost = FormularioHelpers::capturarCampos($campos, $_POST);
    $cadastroAlunoController->processaCadastroAluno($camposPost, $dadosUsuario);
}

$camposAtualizar = array_merge($campos, ['idAluno', 'statusMatricula']);

if (isset($_POST['atualizarAluno'])) {
    $camposPostAtualizar = FormularioHelpers::capturarCampos($camposAtualizar, $_POST);
    $cadastroAlunoController->atualizaCadastroAluno($camposPostAtualizar);
}

$camposFiltros = [
    'nivelFaixa',
    'statusMatricula'
];

$filtro = FormularioHelpers::capturarCampos($camposFiltros, $_GET);

$limitePorPaginacao = 8;
$entradaAlunos = $cadastroAlunoController->mostrarDadosAlunos($filtro, $limitePorPaginacao);
$totalAlunos = $entradaAlunos?->totalAlunos ?? 0;

$entradaMensagem = MensagemHelpers::retornaMensagem() ?? [];
