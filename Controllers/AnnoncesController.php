<?php

namespace App\Controllers;
use App\Models\AnnoncesModel;
use App\Core\Form;


class AnnoncesController extends Controller
{
	/**
	 * Cette méthode affiche une page listant toutes les annonces de la base de données
	 * @return void
	 */
	public function index()
	{
		// On instancie le modèle correspondant à la table 'annonces'
		$annoncesModel = new AnnoncesModel;

		// On va chercher toutes les annonces actives
		$annonces = $annoncesModel->findBy(['actif' => 1]);

		// On génére la vue
		$this->render('annonces' . DIRECTORY_SEPARATOR . 'index', ['annonces' => $annonces]);
	}

	/**
	 * Méthode permettant d'afficher un article à partir de son slug
	 * 
	 * @param int $id
	 * @return void */
	public function lire(int $id)
	{

		// On instancie le modèle
		$model = new AnnoncesModel;

		// On récupère les données 
		$annonce = $model->find($id);

		$this->render('annonces/lire', compact('annonce'));
	}

	/**
	 * Permet d'ajouter une annonce
	 * @return void
	 */
	public function ajouter()
	{
		// On vérifie si l'tuilisateur est connecté 
		if (isset($_SESSION) && !empty($_SESSION['user']['id'])) {
			// Utilisateur connecté
			// On vérifie si le formulaire est complet
			if (Form::validate($_POST, ['titre', 'description'])) {
				// Le formulaire est complet
				// On se protège contre les failles XSS
				// strip_tags, htmlentities, htmlspecialchars
				$titre = strip_tags(($_POST['titre']));
				$description = strip_tags($_POST['description']);

				$annonce = new AnnoncesModel;

				$annonce->setTitre($titre)
					->setDescription($description)
					->setUsers_id($_SESSION['user']['id']);
				// On enregistre 
				$annonce->create();
				$_SESSION['message'] = "Votre annonce a été enregistrée avec succès";

				header('Location: /');

				exit;
			}
			else {
			// Le formulaire est incomplet
				$_SESSION['erreur'] = "Le formulaire est imcomplet !";
				$titre = (isset($_POST['titre']) ? strip_tags($_POST['titre']) : '');
				$description = (isset($_POST['description']) ? strip_tags($_POST['description']) : '');
			}

			$form = new Form;
			$form->debutForm('post','/annonces/ajouter')
				->ajoutLabelFor('titre', 'titre de l\' annonce :')
				->ajoutInput('text', 'titre', [
					'id' => 'titre',
					'classe' => 'form-control',
					'value' => $titre
					])
				->ajoutLabelFor('description', 'Texte de l\'annonce')
				->ajoutTextArea('description', '', [
					'id' => 'description',
					 'class' => "form-control",
					 "value" => $description
					 ])
				->ajoutBouton('Ajouter', ['class' => 'btn btn-primary'])
				->finForm();

			$this->render('annonces/ajouter', ['form' => $form->create()]);
		}
		else {
			// Utilisateur non connecté
			$_SESSION['erreur'] = "Vous devez être connecté pour accéder à cette page";
			header('Location: /users/login');
			exit;
		}
	}

	public function modifier(int $id)
	{
		// On vérifie si l'utilisateur est connecté
		if (isset($_SESSION) && !empty($_SESSION['user']['id'])) {
			// Utilisateur connecté
			$annonceModel = new AnnoncesModel;

			// On cherche l'annonce avec l'id $id
			$annonce = $annonceModel->find($id);

			// Si l'annonce n'existe pas, on retourne à la liste des annonces
			if(!$annonce){
				http_response_code(404);
				$_SESSION['erreur'] = 'L\'annonce recherchée n\'existe pas';
				header('Location: /annonces');
			}

			// On vérifie si l'utilisateur est propriètaire de l'annonce
			if($annonce->users_id !== $_SESSION['user']['id']){
				if(!in_array('ROLE_ADMIN' , $_SESSION['user']['roles'])){
					
					$_SESSION['erreur'] = "Vous n'avez pas accès à cette page";
					header('Location: /annonces');
				}
				
			}

			// On traite le formulaire
			if(Form::validate($_POST, ['titre','description'])){
				$titre = strip_tags($_POST['titre']);
				$description = strip_tags($_POST['description']);

				// On stock l'annonce
				$annonceModif = new AnnoncesModel;

				// On hydrate
				$annonceModif->setId($annonce->id)
					->setTitre($titre)
					->setDescription($description);

				// On met à jour l'annonce
				$annonceModif->update();

				$_SESSION['message'] = "Votre annonce a été modifiée avec succès";

				header('Location: /');
				exit;
			} else {
				$titre = (isset($_POST['titre']) ? strip_tags($_POST['titre']) : '');
				$description = (isset($_POST['description']) ? strip_tags($_POST['description']) : '');
			}

			$form = new Form;
			
			$form->debutForm('post')
				->ajoutLabelFor('titre', 'titre de l\' annonce :')
				->ajoutInput('text', 'titre', [
							'id' => 'titre',
							'classe' => 'form-control',
							'value' => $annonce->titre
					 ])
				->ajoutLabelFor('description', 'Texte de l\'annonce')
				->ajoutTextArea('description', $annonce->description , [
					'id' => 'description',
					'class' => "form-control"
					])
				->ajoutBouton('Modifier', ['class' => 'btn btn-secondary'])
				->finForm();

			$this->render('annonces/modifier', ['form' => $form->create()]);
		}
		else {
			// Utilisateur non connecté
			$_SESSION['erreur'] = "Vous devez être connecté pour accéder à cette page";
			header('Location: /users/login');
			exit;
		}
	}
}