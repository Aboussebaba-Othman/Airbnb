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
        return false;  // Return false if no data is found
    }
    }
        catch (PDOException $e) {
            echo 'error get annonce';
            error_log(" error get annonce" . $e->getMessage());
            return false;
        }
    
   
}


}


