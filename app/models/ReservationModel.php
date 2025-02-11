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

public function fairReservation($user_id, $logement_id, $datedebut, $datefin){
    try{
        $sql = "INSERT INTO Reservations (user_id, logement_id, datedebut, datefin, statut) 
                VALUES (:user_id, :logement_id, :datedebut, :datefin, 'en attente')";
      $stmt = $this->con->prepare($sql);
      $stmt->bindParam('user_id', $user_id);
      $stmt->bindParam('logement_id', $logement_id);
      $stmt->bindParam('datedebut', $datedebut);
      $stmt->bindParam('datefin', $datefin);
      $stmt->excute();
      return $this->con->lastInsertId();
    }

    catch (PDOException $e) {

            error_log("reservation non reussite : " . $e->getMessage());
            return false;
        }
    }
     
public function getReservationById($reservation_id) {
    $sql = "SELECT * FROM Reservations WHERE id = :id";
    $stmt = $this->con->prepare($sql);
    $stmt->bindParam('id', $reservation_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    if(!$result){
      return null ;
      }
      else{
          return $result ;
          
      }

}

public function updateStatus($reservation_id, $status) {
    $sql = "UPDATE Reservations SET statut = :statut WHERE id = :id";
    $stmt = $this->con->prepare($sql);
    $stmt->execute(['statut' => $status, 'id' => $reservation_id]);
}

}


