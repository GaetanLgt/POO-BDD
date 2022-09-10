<?php
namespace App\Models;

use App\Core\Db;

class Model extends Db
{ // Table de la base de données;	
	protected $table;
	// Instance de db	
	private $db;

	public function findAll()
	{
		$query = $this->request('SELECT * FROM ' . $this->table);
		return $query->fetchAll();
	}

	public function findBy(array $_criteres)	{
		$_champs = [];
		$_valeurs = [];

		// On boucle pour éclater le tableau
		foreach ($_criteres as $champ => $valeur) {
			$_champs[] = "$champ = ?";
			$_valeurs[] = $valeur;
		}

		// On transforme le tableau "champs" en chaine de caractères
		$liste_Champs = implode(' AND ', $_champs);

		// On execute la requête
		return $this->request('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_Champs, $_valeurs)->fetchAll();	
	}
	
	public function find(int $id)
	{
		return $this->request("SELECT * FROM  {$this->table} WHERE id = $id ")->fetch();
	}

	public function create()
	{
		$_champs = [];
		$inter = [];
		$_valeurs = [];

		// On boucle pour éclater le tableau
		foreach ($this as $champ => $valeur) {
			if($valeur !== null && $champ != 'db' && $champ != 'table'){
				$_champs[] = $champ;
				$inter[] = "?";
				$_valeurs[] = $valeur;
			}
		}

		// On transforme le tableau "champs" en chaine de caractères
		$liste_Champs = implode(' , ', $_champs);
		$liste_inter = implode(', ', $inter);
		// var_dump($liste_Champs);
		// die($liste_inter);

		// On execute la requête
		return $this->request('INSERT INTO '.$this->table.' ( ' . $liste_Champs . ' ) VALUES (' .$liste_inter.')', $_valeurs );	
	}

	public function update()
	{
		$_champs = [];
		$_valeurs = [];

		// On boucle pour éclater le tableau
		foreach ($this as $champ => $valeur) {
			if($valeur != null && $champ != 'db' && $champ != 'table'){
				$_champs[] = "$champ = ?";
				$_valeurs[] = $valeur;
			}
		}
		$_valeurs[] = $this->id;
		// On transforme le tableau "champs" en chaine de caractères
		$liste_Champs = implode(' , ', $_champs);
		// var_dump($liste_Champs);
		// die($liste_inter);

		// On execute la requête
		return $this->request('UPDATE '.$this->table.' SET ' . $liste_Champs . ' WHERE id= ?', $_valeurs);	
	}

	public function delete(int $id)
	{
		return $this->request("DELETE FROM {$this->table} WHERE id= ?", [$id]);
	}

	public function request(string $sql, array $attributs = null)
	{
		// On recupère l'instance de Db
		$this->db = Db::getInstance();

		// On vérifie si on a attributs 
		if ($attributs !== null) {
			// Requête Préparée
			$query = $this->db->prepare($sql);
			$query->execute($attributs);
			return $query;
		}
		else {
			// Requête simple
			return $this->db->query($sql);
		}
	}

	public function hydrate(object $donnees)
	{
		foreach ($donnees as $key => $value) {
		//on récupère le nom du setter correspondant à la clé
		// titre -> setTitre
			$setter = 'set' . ucfirst($key);
			
			//on vérifie si le setter existe
			if(method_exists($this, $setter)){
				// On apppelle le setter
				$this->$setter($value);
			}
		}
		return $this;
	}

}