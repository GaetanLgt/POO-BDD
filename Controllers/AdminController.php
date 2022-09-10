<?php
namespace App\Controllers;
use App\Models\AnnoncesModel;

class AdminController extends Controller
{
	public function index()
	{
		// On vérifie si on est admin
		if ($this->isAdmin()) {
			$this->render('admin/index', [], 'admin');
		}
	}

	/**
	 * Affiche la liste des annonces
	 * @return 
	 */
	public function annonces()
	{
		if ($this->isAdmin()) {
			$annoncesModel = new AnnoncesModel;

			$annonces = $annoncesModel->findAll();

			$this->render('admin/annonces', compact('annonces'), 'admin');
		}
	}
	private function isAdmin()
	{

		$roles = $_SESSION['user']['roles'];
		// On vérifie si on est connecté et si "ROLE_ADMIN" est dans les rôles admin
		if (isset($_SESSION['user']) && is_array($roles) && in_array('ROLE_ADMIN', $roles)) {
			// On est admin
			return true;
		}
		else {
			$_SESSION['erreur'] = "Vous n'avez pas les droits d'accès";
			header("Location: /");
			exit;
		}
	}
	public function supprimerAnnonce(int $id)
	{
		if ($this->isAdmin()) {
			$annonces = new AnnoncesModel;

			$annonces->delete($id);

			$_SESSION['message'] = "L'annonce a bien été suprimmée.";
			header("Location: /");
			exit;
		}	
	}

	/**
	 * active ou déactive une annonce
	 * @param int $id
	 * @return void
	 */
	public function activeAnnonce(int $id)
	{
		if ($this->isAdmin()) {
			$annoncesModel = new AnnoncesModel;

			$annonceArray = $annoncesModel->find($id);

			if($annonceArray){
				$annonce = $annoncesModel->hydrate($annonceArray);

				$annonce->setActif($annonce->getActif()? 0 : 1);

				$annonce->update();
				
			}
		}
	}
}