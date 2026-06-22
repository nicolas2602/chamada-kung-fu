<?php

namespace App\Helpers;

/**
 * Caminho de pastas para importar arquivos.
 * 
 * @property string RAIZ
 * @property string PUBLIC
 * @property string CONFIG
 * @property string APP
 * @property string MODEL
 * @property string VIEW
 * @property string CONTROLLER
 */
class CaminhoHelpers
{
    public const RAIZ = '../../..';
    public const PUBLIC = self::RAIZ . '/public';
    public const CONFIG = self::RAIZ . '/config';
    public const APP = '/app';
    public const MODEL = self::APP . '/model';
    public const VIEW = self::APP . '/view';
    public const CONTROLLER = self::APP . '/controller';
}