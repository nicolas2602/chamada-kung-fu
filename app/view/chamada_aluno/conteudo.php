<?php

use App\Dto\ChamadaAluno\ChamadaAlunoDto;
use App\Helpers\FormularioHelpers;

/**
 * @param array<ChamadaAlunoDto> $entradaChamada
 * @return void
 */
function chamadaAlunoConteudo(
    array $entradaChamadas
): void {

    $cabecalhoTabela = [
        "Nome completo",
        "Nível Faixa",
        "Status da Chamada",
        "Ação"
    ];

    $corpoTabela = [];

    foreach ($entradaChamadas as $entradaChamada) {

        $idStatusChamada = $entradaChamada->entradaStatusChamada->idStatusChamada;
        $isChecked = $idStatusChamada === 1 ? 'checked' : '';

        $corpoTabela[] = [
            $entradaChamada->nomeAluno . " " . $entradaChamada->sobrenomeAluno,
            $entradaChamada->entradaNivelFaixa->nivelFaixa,
            $entradaChamada->entradaStatusChamada->tipoStatusChamada,
            '
            <div class="form-check form-switch">
                <input class="form-check-input" name="statusChamada[' . $entradaChamada->idChamadaAluno. ']" type="checkbox" role="switch" ' . $isChecked . '>
            </div>
            '
        ];
    }

?>
    <div class="container-fluid">
        <h3>Chamada de Alunos</h3>
        <form method="post">
            <div class="row align-items-end mb-3 mt-3">
                <div class="col-md-10">
                    <?php
                    echo FormularioHelpers::converterTimestampParaData(time(), "d/m/Y H:i:s");
                    ?>
                </div>
                <div class="col-md-2 d-flex justify-content-end align-items-end">
                    <input type="submit" class="btn btn-secondary" name="salvarChamadaAluno" value="Salvar">
                </div>
            </div>
            <div class="tabela">
                <?php
                echo tabela($cabecalhoTabela, $corpoTabela);
                ?>
            </div>
        </form>
    </div>
<?php
}
