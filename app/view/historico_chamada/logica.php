<?php

use App\Controller\LoginController;
use App\Controller\ChamadaAlunoController;

$loginController = new LoginController($conexao);
$chamadaAlunoController = new ChamadaAlunoController($conexao);
$dadosUsuario = $loginController->obterUsuarioLogado();

$entradaHistoricoChamadaAluno = $chamadaAlunoController->listarHistoricoChamadaAlunos();

$limitePorPaginacao = 8;
