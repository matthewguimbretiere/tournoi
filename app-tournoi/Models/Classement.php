<?php

namespace App\Models;

class Classement extends Base
{
    protected $tableName = 'classement';

    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Obtenir la dernière partie d'un joueur par son id
     */
    public function getByIdJoueur( $id ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id_joueur = :id ORDER BY id DESC LIMIT 1";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([":id" => $id]);
        return $sth->fetch();
    }

    /**
     * Ajout d'un joueur
     */
    public function add( $id ) {
        $date = date("Y-m-d");
        $sql = "INSERT INTO `{$this->tableName}` (id_joueur, partie1, partie2, partie3, partie4, total, date_tournoi) VALUES (:id_joueur, 0,0,0,0,0, :dates)";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([":id_joueur" => $id, ":dates" => $date]);
    }

    /**
     * Obtention des dates
     */
    public function getDates() {
        $sql = "SELECT * FROM `{$this->tableName}` GROUP BY date_tournoi ORDER BY id DESC";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * Obtention par dates
     */
    public function getAllByDate( $date ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_tournoi = :datee ORDER BY total DESC";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([":datee" => $date]);
        return $sth->fetchAll();
    }

    /**
     * Suppr par id joueur
     */
    public function deleteByIdJoueur( $id ) {
        $sql = "DELETE FROM `{$this->tableName}` WHERE id_joueur = :id";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([":id" => $id]);
    }

    /**
     * Update
     */
    public function update( $id, $datas) {
        $sql = "UPDATE `{$this->tableName}` SET partie1 = :partie1, partie2 = :partie2, partie3 = :partie3, partie4 = :partie4, date_tournoi = :date_tournoi WHERE id = :id";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([
            ":partie1" => $datas["partie1"],
            ":partie2" => $datas["partie2"],
            ":partie3" => $datas["partie3"],
            ":partie4" => $datas["partie4"],
            ":date_tournoi" => $datas["date_tournoi"],
            ":id" => $id
        ]);
    }
}
?>