<?php
namespace App\models ;

use Core\Database;
use PDO;
use PDOException;

class ReservationModel{

private $con ;

public function __construct()
{
    $this->con = Database::getInstance();
}

public function getAnnonceById($id){
    try{
    $sql = 'SELECT * From annonces where id = :id';
    $stmt = $this->con->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
        return $row;
        } else {
        return false;  
    }
    }
        catch (PDOException $e) {
            echo 'error get annonce';
            error_log(" error get annonce" . $e->getMessage());
            return false;
        } 
    
}

public function addReservation($userId, $annonceId, $dateDebut, $dateFin, $nbChambres) {
    try {
        $sql = "INSERT INTO reservations ( reservationdate, datedebut, datefin, user_id, logement_id,statut,nbrchambres)
                VALUES (CURRENT_DATE, :datedebut, :datefin, :user_id,:logement_id,'en attante' , :nb_chambres) 
                RETURNING id";

        $stmt = $this->con->prepare($sql);

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':logement_id', $annonceId, PDO::PARAM_INT);
        $stmt->bindParam(':datedebut', $dateDebut);
        $stmt->bindParam(':datefin', $dateFin);
        $stmt->bindParam(':nb_chambres', $nbChambres, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['id'] : false;

    } catch (PDOException $e) {
        error_log("Erreur d'ajout réservation: " . $e->getMessage());
        return false;
    }
}


}

