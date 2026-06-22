<?php

/**
 * @param string $nomeUsuario
 * @return void
 */
function paginaPrincipalConteudo(string $nomeUsuario): void
{
?>

<div class="container-fluid py-4">
    <h1 class="mb-3">Bem-vindo, <?= htmlspecialchars($nomeUsuario) ?>!</h1>

    <p>
        Este é o <strong>Registro de Presença</strong>, sistema da nossa academia de Kung-Fu. 
        Ele foi desenvolvido para tornar o gerenciamento da presença dos alunos mais fácil, rápido e organizado.
    </p>

    <div class="row justify-content-start">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Funcionalidades principais</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-3">
                            <strong>Cadastro de Alunos:</strong> Permite registrar novos alunos, mantendo todos os dados atualizados e organizados.
                        </li>
                        <li class="mb-3">
                            <strong>Chamada de Alunos:</strong> Registra a presença dos alunos que participaram do treino no dia.
                        </li>
                        <li class="mb-3">
                            <strong>Histórico de Chamada:</strong> Consulta registros de treinos anteriores, permitindo acompanhar a frequência dos alunos ao longo do tempo.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <p class="mt-3">
        Utilize o menu lateral para navegar entre as páginas e explorar todas as funcionalidades do sistema. 
        Nosso objetivo é ajudar os instrutores a manter o controle dos treinos de forma prática e eficiente.
    </p>
</div>

<?php
}