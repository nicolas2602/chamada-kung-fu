<?php

use App\Dto\HistoricoChamadaAluno\HistoricoChamadaAlunoEntradaDto;
use App\Helpers\FormularioHelpers;

/**
 * @param HistoricoChamadaAlunoEntradaDto $entradaHistoricoChamadaAluno
 * @return void
 */
function historicoChamadaConteudo(
    HistoricoChamadaAlunoEntradaDto $entradaHistoricoChamadaAlunos,
    int $limitePorPaginacao
): void
{

    $cabecalhoTabela = [
        'Data da Chamada',
        'Histórico de registros'
    ];

    $corpoTabela = [];
    $corpoTabelaModal = [];

    $index = 0;

    foreach ($entradaHistoricoChamadaAlunos->entrada as $entradaHistoricoChamadaAluno) {

        $converteDataBrasileira = FormularioHelpers::converterParaDataBrasileira(
            $entradaHistoricoChamadaAluno->dataChamadaAluno
        );
        
        $index++;

        $idModal = "idVisualizar" . $index;

        foreach ($entradaHistoricoChamadaAluno->entrada as $entradaChamadaAluno) {
            $corpoTabelaModal[$idModal][] = [
                $entradaChamadaAluno->nomeAluno . " " . $entradaChamadaAluno->sobrenomeAluno,
                $entradaChamadaAluno->nivelFaixa,
                $entradaChamadaAluno->statusChamada,
            ];
        }

        $corpoTabela[] = [
            $converteDataBrasileira,
            botaoModal(
                "Visualizar",
                $idModal,
                [],
                "btn-secondary"
            )
        ];
    }

    foreach ($corpoTabelaModal as $idModal => $dadosModal) {
        estruturaModalComTabela(
            $idModal,
            "Alunos cadastrados",
            tabela(
                ['Nome completo', 'Nível da faixa', 'Status da chamada'],
                $dadosModal
            ),
        );
    }

?>

    <div class="container-fluid">
        <h3>Histórico de Chamada</h3>
        <div class="tabela">
            <?php
            echo tabela($cabecalhoTabela, $corpoTabela);
            ?>
            <div class="d-flex justify-content-end align-items-end">
                <?php
                paginacao(
                    $limitePorPaginacao, 
                    $entradaHistoricoChamadaAlunos->totalHistoricoChamadas, 
                    []
                );
                ?>
            </div>
        </div>
    </div>

<?php
}
