<?php

/**
 * Botão para abrir o modal (janela).
 * 
 * @param string $tituloBotao
 * @param string $idModal - Será uma referência ao valor do atributo "id" do HTML.
 * @param array $dados - Se refere aos atributos criados do HTML. O objetivo é captar os dados armazenados e passar para JavaScript exibir os valores.
 * @param string $corBotao
 * @return string
*/
function botaoModal(
    string $tituloBotao,
    string $idModal,
    array $dados = [],
    string $corBotao = "btn-primary"
): string {

    $html = '<button type="button" class="btn ' . $corBotao . ' btn-sm" data-bs-toggle="modal" ';
    $html .= 'data-bs-target="#' . $idModal . '" ';

    if (count($dados) !== 0) {
        foreach ($dados as $dado => $chaveDado) {
            $html .= 'data-' . $dado  . '=' . $chaveDado . ' ';
        }
    }

    $html .= '>';
    $html .= $tituloBotao;
    $html .= '</button>';

    return $html;
}

/**
 * Corpo para exibir dentro do modal (janela).
 * 
 * @param string $idModal - Se refere ao valor do atributo "id" do HTML,
 * @param string $tituloCabecalho - O nome do cabeçalho da Modal,
 * @param array $corpoModal - Contém os campos HTML estrturados,
 * @param string $nomeBotao - Se refere ao atributo "name" do HTML,
 * @param string $tituloBotao - O nome do botão da Modal,,
 * @param string $corBotao - Cor do botão
 * @return void
 */
function estruturaModal(
    string $idModal,
    string $tituloCabecalho,
    array $corpoModal,
    string $nomeBotao,
    string $tituloBotao,
    string $corBotao = "btn-primary"
): void {
?>
    <div class="modal fade" id="<?= $idModal ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel"><?= $tituloCabecalho ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    foreach ($corpoModal as $corpo) {
                        echo $corpo;
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <input type="submit" name="<?= $nomeBotao ?>" class="btn <?= $corBotao ?>" value="<?= $tituloBotao ?>">
                </div>
            </div>
        </div>
    </div>
<?php
}

/**
 * Corpo da tabela para exibir dentro do modal (janela).
 * 
 * @param string $idModal - Se refere ao valor do atributo "id" do HTML.
 * @param string $tituloCabecalho - O nome do cabeçalho da Modal.
 * @param array $corpoModal - Contém os campos HTML estrturados.
 * @return void
 */
function estruturaModalComTabela(
    string $idModal,
    string $tituloCabecalho,
    string $corpoModal,
): void {
?>
    <div class="modal fade" id="<?= $idModal ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel"><?= $tituloCabecalho ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    echo $corpoModal;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
