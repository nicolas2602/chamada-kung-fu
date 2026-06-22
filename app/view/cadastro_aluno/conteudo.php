<?php

use App\Dto\CadastroAluno\CadastroAlunoEntradaDto;
use App\Dto\NivelFaixaDto;
use App\Dto\StatusMatriculaDto;
use App\Helpers\FormularioHelpers;

/**
 * @param CadastroAlunoEntradaDto|false $entradaAlunos
 * @param array<NivelFaixaDto> $niveisFaixas
 * @param array<StatusMatriculaDto> $statusMatricula
 * @param int $limitePorPaginacao
 * @param int $totalRegistro
 * @param array{
 *  'nivelFaixa': int,
 *  'statusMatricula': int
 * } $filtro
 */
function cadastroAlunoConteudo(
    CadastroAlunoEntradaDto|false $entradaAlunos,
    array $niveisFaixas,
    array $statusMatricula,
    int $limitePorPaginacao,
    int $totalRegistro,
    array $filtro,
): void {

    $cabecalhoTabela = [
        "Nome Completo",
        "Data de Nascimento",
        "Nível da Faixa",
        "Status da Matrícula",
        "Ação"
    ];

    $corpoTabela = [];

    $idBtnAtualizarAluno = "btnAtualizarAluno";

    foreach ($entradaAlunos?->entrada ?? [] as $entradaAluno) {

        $converteDataBrasileira = FormularioHelpers::converterParaDataBrasileira(
            $entradaAluno->dataNascimento
        );

        $arrayAtributoAlunoHtml = [
            'id-aluno' => $entradaAluno->idAluno,
            'nome-aluno' => $entradaAluno->nomeAluno,
            'sobrenome-aluno' => $entradaAluno->sobrenomeAluno,
            'data-nascimento' => $entradaAluno->dataNascimento,
            'nivel-faixa' => $entradaAluno->entradaNivelFaixa->idNivelFaixa,
            'status-matricula' => $entradaAluno->entradaStatusMatricula->idStatusMatricula
        ];

        $corpoTabela[] = [
            $entradaAluno->nomeAluno . " " . $entradaAluno->sobrenomeAluno,
            $converteDataBrasileira,
            $entradaAluno->entradaNivelFaixa->nivelFaixa,
            $entradaAluno->entradaStatusMatricula->statusMatricula,
            botaoModal(
                "Editar",
                $idBtnAtualizarAluno,
                $arrayAtributoAlunoHtml
            )
        ];
    }

    $corpoModal = [
        campo("Nome", "text", 'nomeAluno'),
        campo("Sobrenome", "text", 'sobrenomeAluno'),
        campo("Data de Nascimento", "date", 'dataNascimento'),
        campoSelecaoNiveisFaixas($niveisFaixas),
    ];
?>
    <form method="post">
        <?php
        estruturaModal(
            $idBtnAtualizarAluno,
            "Atualizar os dados do aluno",
            array_merge(
                $corpoModal,
                [
                    campoSelecaoStatusMatricula($statusMatricula),
                    campo("", 'hidden', 'idAluno', false)
                ]
            ),
            "atualizarAluno",
            "Atualizar"
        );
        ?>
    </form>
    <div class="container-fluid">
        <h3>Cadastro de Alunos</h3>
        <div class="row align-items-end mb-3 mt-3">
            <div class="col-md-10">
                <form method="get" class="row g-2">
                    <div class="col-md-4">
                        <?= campoSelecaoNiveisFaixas($niveisFaixas) ?>
                    </div>
                    <div class="col-md-4">
                        <?= campoSelecaoStatusMatricula($statusMatricula) ?>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="g-2 mb-1">
                            <button type="submit" class="btn btn-secondary btn-sm" name="filtrarAluno">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2 d-flex justify-content-end align-items-end">
                <div class="g-2 mb-1">
                    <form method="post">
                        <?php
                        $idBotao = "btnCadastrarAluno";
                        echo botaoModal("Cadastrar Aluno", $idBotao, [], "btn-success");
                        estruturaModal(
                            $idBotao,
                            "Cadastrar Aluno",
                            $corpoModal,
                            "cadastraAluno",
                            "Cadastrar",
                            "btn-success"
                        );
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="tabela">
            <?php
            echo tabela($cabecalhoTabela, $corpoTabela);
            ?>
            <div class="d-flex justify-content-end align-items-end">
                <?php
                paginacao($limitePorPaginacao, $totalRegistro, $filtro);
                ?>
            </div>
        </div>
    </div>
<?php
}
