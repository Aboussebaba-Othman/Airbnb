<?php

namespace App\models;

use Core\Database;
use PDO;
use PDOException;

class PaiementModel {
    private $con;

    public function __construct() {
        $this->con = Database::getInstance();
    }

    public function enregistrerPaiement($reservation_id, $user_id, $montant, $methode) {
        try{
            $sql = "INSERT INTO Paiements (reservation_id, user_id, montant, methode) 
                VALUES (:reservation_id, :user_id, :montant, :methode)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam('reservation_id', $reservation_id);
        $stmt->bindParam('user_id', $user_id);
        $stmt->bindParam('montant', $montant);
        $stmt->bindParam('methode', $methode);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row)
        return $row;
      }
  
      catch (PDOException $e) {
  
              error_log("enregestrement de paiement non reussi : " . $e->getMessage());
              return false;
          }
      }
        

    }
