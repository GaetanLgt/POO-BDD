<?php
namespace App;


class Autoloader
{
	static function register()
	{
		spl_autoload_register([
			__CLASS__,
			'autoload'
		]);
	}

	static function autoload($class)
	{
		// On récupère dans $class la totalité de la classe appelée (App\Client\Compte)
		// On retire App\ (client\Compte)
		$class =  str_replace( __NAMESPACE__ .'\\','',$class);

		// On remplace les \ par un spéparateur de dossier
		$class = str_replace('\\', DIRECTORY_SEPARATOR , $class);
		// echo $class;

		$fichier = __DIR__ . DIRECTORY_SEPARATOR . $class . ".php";
		// On vérifie si le fichier existe
		if(file_exists($fichier)){
			require_once $fichier;
		}
	}
}