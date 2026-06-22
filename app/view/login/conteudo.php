<?php

/**
 * @return void
 */
function loginConteudo(): void
{
?>
    <h5 class="text-center mb-4 text-danger">Login</h5>
    <form method="post" class="formulario">
        <div class="g-2 mb-1">
            <label class="form-label text-light">E-mail ou Usuário</label>
            <input type="text" class="form-control" name="emailOuUsuario" placeholder="Digite o e-mail ou usuário">
        </div>

        <div class="g-2 mb-1">
            <label class="form-label text-light">Senha</label>
            <input type="password" class="form-control" name="senhaUsuario" placeholder="Digite a senha">
        </div>

        <input type="submit" class="btn btn-danger w-100 mt-3" name="loginUsuario" value="Entrar" />
    </form>
<?php
}
