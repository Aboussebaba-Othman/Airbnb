<?php
namespace App\Models;

use Core\Model;
use PDO;

class Annonce extends Model {
    protected $table = 'annonces';

    public function getAllAnnonces() {
        $query = "SELECT a.*, u.username as owner_name, 
                  COALESCE((SELECT COUNT(*) FROM reservations r WHERE r.logement_id = a.id), 0) as total_reservations,
                  COALESCE((SELECT AVG(note) FROM avis av WHERE av.logement_id = a.id), 0) as rating
                  FROM {$this->table} a 
                  JOIN users u ON a.owner_id = u.id 
                  ORDER BY a.id DESC";

        return $this->query($query);
    }

    public function getDashboardStats() {
        return [
            'total_revenue' => $this->getTotalRevenue(),
            'reservations_count' => $this->getCount('reservations'),
            'avg_rating' => $this->getAverageRating(),
            'new_reviews' => $this->getNewReviewsCount()
        ];
    }

    private function getTotalRevenue() {
        return $this->queryScalar(
            "SELECT COALESCE(SUM(montant), 0) FROM paiements"
        );
    }

    private function getAverageRating() {
        return $this->queryScalar(
            "SELECT COALESCE(ROUND(AVG(note), 1), 0) FROM avis"
        );
    }

    private function getNewReviewsCount() {
        return $this->queryScalar(
            "SELECT COUNT(*) FROM avis WHERE date_creation >= NOW() - INTERVAL '30 days'"
        );
    }

    private function getCount($table) {
        return $this->queryScalar("SELECT COUNT(*) FROM {$table}");
    }


    public function getPendingAnnonces() {
        $query = "SELECT a.*, u.username as owner_name, 
                  COALESCE(AVG(av.note), 0) as rating,
                  COUNT(DISTINCT r.id) as total_reservations
                  FROM annonces a 
                  LEFT JOIN users u ON a.owner_id = u.id 
                  LEFT JOIN avis av ON a.id = av.logement_id
                  LEFT JOIN reservations r ON a.id = r.logement_id
                  GROUP BY a.id, u.username
                  ORDER BY a.id DESC";
        
        return $this->query($query);
    }
    
    public function updateValidation($id, $status) {
        return $this->update($id, ['validate' => $status]);
    }
}