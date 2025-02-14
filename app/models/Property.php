<?php
namespace App\Models;

use Core\Model;
use PDO; 

class Property extends Model {
    protected $table = 'annonces';
    public function findByOwner($ownerId) {
    try {
        $stmt = $this->db->prepare("
            SELECT * FROM $this->table 
            WHERE owner_id = :owner_id 
        ");
        $stmt->execute(['owner_id' => $ownerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    } catch (\PDOException $e) {
        exit;
    }
    }

    public function createAnnonce($data) {
        $equipements = json_encode($data['equipements']);
        $stmt = $this->db->prepare("
            INSERT INTO $this->table 
                (title, photo, prix, equipements, description, categorie, owner_id)
            VALUES 
                (:title, :photo, :prix, :equipements, :description, :categorie, :owner_id)
        ");
        $stmt->execute([
            ':title' => $data['title'],
            ':photo' => $data['photo'] ?? null,
            ':prix' => $data['prix'],
            ':equipements' => $equipements,
            ':description' => $data['description'],
            ':categorie' => $data['categorie'],
            ':owner_id' => $data['owner_id']
        ]);
        return $this->db->lastInsertId();
    }

    public function updateAnnonce($id, $data) {
        if (isset($data['equipements'])) {
            $data['equipements'] = json_encode($data['equipements']);
        }
        return $this->update($id, $data);
    }

    public function deleteAnnonce($id) {
        return $this->delete($id);
    }
}