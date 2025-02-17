<?php
namespace App\models;

use Core\Database;
use PDO;

class AnnonceModel {
    private $con;

    public function __construct() {
        $this->con = Database::getInstance(); 
    }

    public function getAll() {
        $sql = "SELECT a.*, u.username AS owner_name
                FROM Annonces a
                JOIN Users u ON a.owner_id = u.id
                WHERE a.validate = 'valider'";
                
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; 
    }
     public function getAllbySearch($name) {
        $sql = "SELECT a.*, u.username AS owner_name
                FROM Annonces a
                JOIN Users u ON a.owner_id = u.id
                WHERE a.validate = 'valider' and a.title like :name";
                
        $stmt = $this->con->prepare($sql);
        $stmt->execute([
            ":name" => "%$name%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; 
    }
    public function getAllFilter($name) {
        $sql = "SELECT a.*, u.username AS owner_name
                FROM Annonces a
                JOIN Users u ON a.owner_id = u.id
                WHERE a.validate = 'valider' and a.category = :name";
                
        $stmt = $this->con->prepare($sql);
        $stmt->execute([
            ":name" => "%$name%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; 
    }
}
