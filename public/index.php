<?php
//on définit une constante le dossier racine du projet

use App\Autoloader;
use App\Core\Main;

define('ROOT', dirname(__DIR__));

// On importe l'autoloader
require_once ROOT . '/Autoloader.php';
Autoloader::register();

// On instancie main 
$app = new Main();

// On démarre l'apllication
$app->start();