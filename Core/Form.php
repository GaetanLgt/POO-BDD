<?php

namespace App\Core;

class Form
{
	private $formCode = '';
	
	/**
	 * Générer le formulaire HTML
	 * @return string
	 */
	public function create(): string
	{
		return $this->formCode;
	}

	/**
	 * Valide si tous les champs proposé sont remplis
	 *
	 * @param array $form Tableau issu du formaulaire ($_POST, $_GET)
	 * @param array $champs Tableau listant les champs obligatoire
	 * @return bool
	 */
	public static function validate(array $form, array $champs)
	{
		// On parcourt les champs
		foreach($champs as $champ){
			// Si le champs est absent ou vide dans le formulaire
			if(!isset($form[$champ])|| empty($form[$champ])){
				return false;
			} 

			
		}
		return true;
	}

	/**
	 * Ajoute les attributs envoyés à la balise
	 * @param array $attributs Tableau associatif ['class' => 'form-control', 'required' => true]
	 * @return string Chaine de caractère générée
	 */
	private function ajoutAttibuts(array $attributs): string 
	{
		// On initialise une chaine de caractères
		$str = '';

		// On liste les attributs "courts"
		$courts = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];

		// On boucle sur le tableau d'attributs
		foreach($attributs as $attribut => $valeur){
			// Si l'attribut est dans la liste des attributs courts
			if(in_array($attribut, $courts) && $valeur == true){
				$str .= " $attribut";
			} else {
				// On ajoute attribut='valeur'
				$str .= " $attribut=\" $valeur\"";
			}
		}
		
		return $str;
	}

	/**
	 * balise d'ouverture du formulaire
	 * @param string $methode Méthode du formaulaire (post ou get)
	 * @param string $action Action du formulaire
	 * @param array $attributs Attributs
	 * @return Form
	 */
	public function debutForm(string $methode = 'post', string $action = '#' , array $attributs = []): self
	{
		// On crée la balise form
		$this->formCode .= "<form action='$action' method='$methode' ";
		
		
		$this->formCode .= $attributs ? $this->ajoutAttibuts($attributs).'>' : '>';
		
		return $this;
	}

	/**
	 * Balise de fermeture du formulaire
	 * @return Form
	 */
	public function finForm():self
	{
		$this->formCode .= "</form>";
		return $this;
	}

	/**
	 * Ajout des labels automatique
	 * @param string $for
	 * @param string $texte
	 * @param array $attributs
	 * @return Form
	 */
	public function ajoutLabelFor( string $for, string $texte, array $attributs = []): self
	{
		// On ouvre la balise 
		$this->formCode .= "<label for='$for'";

		// On ajoute les attributs 
		$this->formCode .= $attributs ? $this->ajoutAttibuts($attributs) : '';

		// On ajoute le texte et on ferme le From
		$this->formCode .= ">$texte</label>";
		
		return $this;

	}

	public function ajoutInput(string $type,string $nom ,array $attibuts = []): self 
	{
		// On ouvre la balise 
		$this->formCode .= "<input type='$type' name='$nom'";

		$this->formCode .= $attibuts ? $this->ajoutAttibuts($attibuts) . '>' : '>';

		return $this;
	}

	public function ajoutTextArea(string $nom, string $valeur ='', array $attributs = []):self 
	{
		// On ouvre la balise 
		$this->formCode .= "<textarea name='$nom'";

		// On ajoute les attributs 
		$this->formCode .= $attributs ? $this->ajoutAttibuts($attributs) : '';

		// On ajoute le texte et on ferme le From
		$this->formCode .= ">$valeur</textarea>";
		
		return $this;
	}

	public function ajoutSelect(string $nom, array $options, array $attibuts = []):self
	{
		// On crée le select
		$this->formCode .= "<select name='$nom'";

		// On ajoute les attributs
		$this->formCode .= $attibuts ? $this->ajoutAttibuts($attibuts) . '>' : '>';

		foreach ($options as $valeur => $texte ){
			$this->formCode .= "<option value=\"$valeur\">$texte</option>";
		}
		$this->formCode .= '</select>';
		return $this;
	}

	public function ajoutBouton( string $texte , array $attributs = []): self 
	{
		// On ajoute le bouton
		$this->formCode .= "<button ";
		
		// On ajoute les attributs
		$this->formCode .= $attributs ? $this->ajoutAttibuts($attributs): '';
		
		// On referme la basile après ajout du texte
		$this->formCode .= ">$texte</button>";

		return $this;
	}
}