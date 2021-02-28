<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Joueurs;
use App\Models\Classement;

class FrontController extends Controller {

  /**
   * Affiche la page d'accueil
   */
  public function index() {

    $parties = Classement::getInstance()->getAllByDate( date("Y-m-d") );
    $classement = array();
    // Mise en place du classement
    foreach( $parties as $partie) {
      $joueur = Joueurs::getInstance()->get( $partie["id_joueur"]);
      array_push($classement, ["joueur" => $joueur, "parties" => $partie]);
    }
    // Vérification si l'utilisateur existe
    $userExist = Joueurs::getInstance()->userExist( $_SERVER['REMOTE_ADDR'] );
    // Vérification si l'admin existe
    if( !empty($_SESSION) ) {
      $adminExist = Admin::getInstance()->isAdmin( $_SESSION["pseudo"], $_SESSION["motdepasse"]);
    } else {
      $adminExist = false;
    }

    // Obtention des dates
    $dates = Classement::getInstance()->getDates();
    
    $this->display(
      'front/index.html.twig',
      [
        'classement' => $classement,
        'userExist' => $userExist,
        'adminExist' => $adminExist,
        'dates' => $dates,
        'ip' => $_SERVER["REMOTE_ADDR"]
      ]
    );
  }

  public function indexDate( $date ) {

    $parties = Classement::getInstance()->getAllByDate( $date );
    $classement = array();
    // Mise en place du classement
    foreach( $parties as $partie) {
      $joueur = Joueurs::getInstance()->get( $partie["id_joueur"]);
      array_push($classement, ["joueur" => $joueur, "parties" => $partie]);
    }
    // Vérification si l'utilisateur existe
    $userExist = Joueurs::getInstance()->userExist( $_SERVER['REMOTE_ADDR'] );
    // Vérification si l'admin existe
    if( !empty($_SESSION) ) {
      $adminExist = Admin::getInstance()->isAdmin( $_SESSION["pseudo"], $_SESSION["motdepasse"]);
    } else {
      $adminExist = false;
    }
    // Obtention des dates
    $dates = Classement::getInstance()->getDates();
    $this->display(
      'front/index.html.twig',
      [
        'classement' => $classement,
        'userExist' => $userExist,
        'adminExist' => $adminExist,
        'dates' => $dates,
        'ip' => $_SERVER["REMOTE_ADDR"]
      ]
    );
  }

  /**
  * Sauvegarde d'un nouveau joueur par le joueur
  **/
  public function newUser() {
    Joueurs::getInstance()->add( $_POST );
    $joueur = Joueurs::getInstance()->userExist( $_SERVER["REMOTE_ADDR"]);
    Classement::getInstance()->add( $joueur["id"] );
    redirect('/');
  }
}