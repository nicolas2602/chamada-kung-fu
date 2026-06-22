<?php

namespace App\Helpers;

class ValidacaoHelpers
{

    /**
     * Verificar se a variável do tipo texto está vazio
     * 
     * @param string $texto
     * @return bool
     */
    public static function ehTextoVazio(string $texto): bool
    {
        return $texto !== '';
    }

    /**
     * Verificar se a variável do inteiro texto está vazio
     * 
     * @param string $texto
     * @return bool
     */
    public static function ehInteiroVazio(int $numero): bool
    {
        return $numero !== 0;
    }

    /**
     * 
     * @param string $texto
     * @param int $min
     * @return bool
     */
    public static function validaUsuario(string $texto, int $min = 3): bool
    {
        $texto = trim($texto);

        if (mb_strlen($texto) < $min) {
            return false;
        }

        if (!preg_match('/[a-z]/', $texto)) {
            return false;
        }

        if (!preg_match('/\d/', $texto)) {
            return false;
        }

        return true;
    }

    /**
     * 
     * Formata e verifica se está no formato de e-mail.
     * 
     * @param string $nomeVariavel
     * @return bool
     */
    public static function validaEmail(string $email): bool
    {
        $email = trim($email);

        $sanitizaEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        return filter_var($sanitizaEmail, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Verifica se o formato está correto.
     * 
     * @param string $senha
     * @return bool
     */
    public static function validaSenha(string $senha): bool
    {
        if (mb_strlen($senha) < 8 || mb_strlen($senha) > 12) {
            return false;
        }
        if (!preg_match('/[a-z]/', $senha)) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $senha)) {
            return false;
        }
        if (!preg_match('/\d/', $senha)) {
            return false;
        }
        if (!preg_match('/[\W_]/', $senha)){
            return false;
        }

        return true;
    }

}