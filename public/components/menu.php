<?php

/**
 * Menu de navegação para as páginas.
 * @param string $nomeUsuario
 * @param string $paginaAtual
 * @return void
 */
function menu(string $nomeUsuario, string $paginaAtual): void
{
?>
<aside class="sidebar p-3 d-flex flex-column">

        <div class="mb-2 pt-2 pb-2">
            <span class="nome-sistema">Registro de Treino</span>
        </div>

        <div class="mb-4 pt-3 pb-3 border-top border-bottom border-secondary">
            <span class="nome-usuario text-white fw-semibold">
                Usuário: <strong><?= $nomeUsuario ?></strong>
            </span>
        </div>

        <ul class="nav flex-column gap-1 flex-grow-1">
            <li class="nav-item">
                <a class="nav-link <?= $paginaAtual === 'inicio' ? 'active' : ''?>" href="/app/view/pagina_principal">
                    Início
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $paginaAtual === 'cadastro_aluno' ? 'active' : ''?>" href="/app/view/cadastro_aluno">
                    Cadastro de Alunos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $paginaAtual === 'chamada_aluno' ? 'active' : ''?>" href="/app/view/chamada_aluno">
                    Chamada de Alunos
                </a>
            </li>
            <li class="nav-item mt-auto pt-3 border-top border-secondary">
                <a class="nav-link text-danger" href="/public/logout.php">Sair</a>
            </li>
        </ul>
    </aside>
<?php
}
