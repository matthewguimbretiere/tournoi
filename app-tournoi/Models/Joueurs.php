<?php

namespace App\Models;

class Joueurs extends Base
{
    protected $tableName = 'joueurs';

    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Vérification si l'utilisateur existe
     */
    public function userExist( $ip ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE ip = :ip";
        $sth = self::$dbh->prepare($sql);
 		$sth->execute([':ip' => $ip]);
 		return $sth->fetch();
    }

    /**
     * Obtention par le pseudo
     */
    public function userExistByPseudo( $pseudo ) {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE pseudo = :pseudo";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([":pseudo" => $pseudo]);
        return $sth->fetch();
    }

    /**
     * Update
     */
    public function update( $id, $datas) {
        $sql = "UPDATE `{$this->tableName}` SET pseudo = :pseudo, plateforme = :plateforme WHERE id = :id";
        $sth = self::$dbh->prepare( $sql );
        $sth->execute([
            ":pseudo" => $datas["pseudo"],
            ":plateforme" => $datas["plateforme"],
            ":id" => $id
        ]);
    }
    
}
?>