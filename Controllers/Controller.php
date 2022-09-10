<?php

namespace App\Controllers;

abstract class Controller
{
	protected $template = 'default';

	public function render(string $fichier,array $donnees = [], string $template = 'default')
	{
		// On extrait le contenu des données
		extract($donnees);

		ob_start();
		// A partir de ce point toute sortie est conservée en mémoire

		// On crée le chemin vers la vue
		require_once ROOT . DIRECTORY_SEPARATOR. 'Views' . DIRECTORY_SEPARATOR. $fichier . '.php';
		
		// Tranfère le buffer dans le contenu
		$contenu = ob_get_clean();

		require_once ROOT . '/Views/'.$template.'.php';
		
	}
}