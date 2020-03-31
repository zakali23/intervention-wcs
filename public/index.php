<?php
/**
 * Created by PhpStorm.
 */


if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // retourne la requête telle quelle.
}

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/dispatcher.php';


