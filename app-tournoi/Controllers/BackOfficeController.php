<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Formula;
use App\Models\Joueurs;
use App\Models\Classement;

class BackOfficeController extends Controller {

  /**
   * Login dans l'application BackOffice
   */
  public function login() {
    $this->display(
      'backoffice/login.html.twig'
    );
  }

  /**
  * Vérifier le login.
  **/
  public function loginCheck() {
  	$check = Admin::getInstance()->isAdmin( $_POST['pseudo'], $_POST['password']);
  	if ( $check ) {
  		// ouvrir une session en mode ADMIN
  		$_SESSION['pseudo'] = $_POST['pseudo'];
  		$_SESSION['motdepasse'] = $_POST['password'];
  		// redirection vers le backoffice
  		redirect( '/backoffice/liste-joueurs ');
  	} else {
  		redirect('/login');
  	}
  }

  /**
  * Fermer la session administrateur
  **/
  public function delog() {
  	unset($_SESSION);
  	session_destroy();
  	redirect('/');
  }

  /**
   * Liste des joueurs
   */
  public function listeJoueurs() {
    $parties = Classement::getInstance()->getAllByDate( date("Y-m-d") );
    $classement = array();
    // Mise en place du classement
    foreach( $parties as $partie) {
      $joueur = Joueurs::getInstance()->get( $partie["id_joueur"]);
      array_push($classement, ["joueur" => $joueur, "parties" => $partie]);
    }
// Obtention des dates
$dates = Classement::getInstance()->getDates();
    $this->display(
      'backoffice/joueurs.html.twig',
      [
        'classement' => $classement, 
        'dates' => $dates,
        'activItem' => "joueurs"
      ]
    );
  }

  /**
   * Liste des joueurs
   */
  public function listeJoueursDates( $date ) {
    $parties = Classement::getInstance()->getAllByDate( $date );
    $classement = array();
    // Mise en place du classement
    foreach( $parties as $partie) {
      $joueur = Joueurs::getInstance()->get( $partie["id_joueur"]);
      array_push($classement, ["joueur" => $joueur, "parties" => $partie]);
    }
// Obtention des dates
$dates = Classement::getInstance()->getDates();
    $this->display(
      'backoffice/joueurs.html.twig',
      [
        'classement' => $classement, 
        'dates' => $dates,
        'activItem' => "joueurs"
      ]
    );
  }

  /**
   * Nouveau joueur
   */
  public function newJoueur() {
    $this->display(
      'backoffice/new-joueurs.html.twig',
      [
        'activItem' => "new-joueur"
      ]
    );
  }

  /**
   * Save nouveau joueur
   */
  public function saveJoueur() {
    Joueurs::getInstance()->add( $_POST );
    $joueur = Joueurs::getInstance()->userExistByPseudo( $_POST["pseudo"] );
    Classement::getInstance()->add( $joueur["id"] );
    redirect('/backoffice/liste-joueurs');
  }

  /**
   * delete joueur
   */
  public function deleteJoueur( $id ) {
    Joueurs::getInstance()->delete( $id );
    Classement::getInstance()->deleteByIdJoueur( $id );
    redirect('/backoffice/liste-joueurs');
  }

  /**
   * Edition d'un joueur
   */
  public function editJoueur( $idJoueurs, $idParties ) {
    $joueur = Joueurs::getInstance()->get($idJoueurs);
    $partie = Classement::getInstance()->get($idParties);
    $this->display(
      'backoffice/edit-joueurs.html.twig',
      [
        'activItem' => "joueurs",
        'joueur' => $joueur,
        'partie' => $partie
      ]
    );
  }

  /**
   * Dauevagrde de mise à jour
   */
  public function updateJoueur( $idJoueurs, $idParties ) {
    Joueurs::getInstance()->update( $idJoueurs, $_POST);
    Classement::getInstance()->update( $idParties, $_POST);
    redirect('/backoffice/liste-joueurs');
  }

}

?>