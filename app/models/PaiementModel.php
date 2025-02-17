<?php
namespace App\models;

use Core\Database;
use PDO;

class PaiementModel {
    private $con;

    public function __construct() {
        $this->con = Database::getInstance();
    }

    public function addPaiement($reservationId, $userId, $montant, $methode) {
        $sql = "INSERT INTO paiements (reservation_id, user_id, montant, methode) VALUES (:reservation_id, :user_id, :montant, :methode)";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([
            'reservation_id' => $reservationId,
            'user_id' => $userId,
            'montant' => $montant,
            'methode' => $methode
        ]);
    }
}
