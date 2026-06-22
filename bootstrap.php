<?php

define("CAMINHO_RAIZ", __DIR__);

require_once(CAMINHO_RAIZ . "/vendor/autoload.php");

date_default_timezone_set('America/Sao_Paulo');

$dotenv = Dotenv\Dotenv::createImmutable(CAMINHO_RAIZ);
$dotenv->load();