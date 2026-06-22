<?php

/**
 * Exibir mensagens dependendo do comportamento do sistema.
 * 
 * @param array{
 * 'mensagem': string,
 * 'tipoMensagem': string
 * } | false $entradaMensagem
 * @return void
 */
function mensagem(array|false $entradaMensagem): void
{
    if ($entradaMensagem) {
?>

        <div class="alert alert-<?= $entradaMensagem['tipoMensagem'] ?>">
            <?= $entradaMensagem['mensagem'] ?>
        </div>

<?php
    }
}
