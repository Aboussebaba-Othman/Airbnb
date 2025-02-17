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
        try {
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
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }
    }

    public function updateAnnonce($id, $data) {
        try {
            if (isset($data['equipements'])) {
                $data['equipements'] = json_encode($data['equipements']);
            }
            return $this->update($id, $data);
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }

        
    }

    public function deleteAnnonce($id) {
        try {
            return $this->delete($id);
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }

    }

    public function getReservationsThisMonth($ownerId) {
        try {
            $query = "
                SELECT COUNT(*) as total_reservations 
                FROM reservations r
                JOIN annonces a ON r.logement_id = a.id
                WHERE a.owner_id = :owner_id 
                AND DATE_TRUNC('month', r.reservationDate) = DATE_TRUNC('month', CURRENT_DATE)
            ";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['owner_id' => $ownerId]);

            return $stmt->fetch(PDO::FETCH_ASSOC)['total_reservations'];
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }


    }

    public function getRevenueThisMonth($ownerId) {
        try {
            $query = "
                SELECT COALESCE(SUM(p.montant), 0) as total_revenue 
                FROM paiements p
                JOIN reservations r ON p.reservation_id = r.id
                JOIN annonces a ON r.logement_id = a.id
                WHERE a.owner_id = :owner_id 
                AND DATE_TRUNC('month', p.date_paiement) = DATE_TRUNC('month', CURRENT_DATE)
            ";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['owner_id' => $ownerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }

    }

    public function getOccupancyRateThisMonth($ownerId) {
        $query = "
            SELECT 
                COUNT(DISTINCT r.id) * 100.0 / NULLIF(COUNT(DISTINCT a.id), 0) as occupancy_rate
            FROM annonces a
            LEFT JOIN reservations r ON a.id = r.logement_id 
            AND DATE_TRUNC('month', r.datedebut) = DATE_TRUNC('month', CURRENT_DATE)
            WHERE a.owner_id = :owner_id
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['owner_id' => $ownerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['occupancy_rate'];
    }
}