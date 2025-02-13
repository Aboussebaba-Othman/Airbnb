<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use Core\View\View;

class ReservationController
{

    public function getAnnonceReserve($id)
    {
        
        $reservationModel = new ReservationModel();
        $annonce = $reservationModel->getAnnonceById($id);
        
        if ($annonce) {  
            View::render('reservation.twig', ['annonce' => $annonce]);
        } else {
            echo "Annonce not found";
        }
    }

    public function reserver() {
        Session::start(); 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = 4; // Remplace cela par Session::get('user_id') lorsque l'auth fonctionne
            
            // Vérifier que les champs ne sont pas vides
            if (!isset($_POST['annonce_id'], $_POST['datedebut'], $_POST['datefin'], $_POST['nb_chambres'])) {
                die("Erreur : Données invalides.");
            }
    
            $annonceId = intval($_POST['annonce_id']);
            $dateDebut = trim($_POST['datedebut']);
            $dateFin = trim($_POST['datefin']);
            $nbChambres = intval($_POST['nb_chambres']);
    
          
            if (empty($dateDebut) || empty($dateFin) || $dateDebut >= $dateFin) {
                die("Erreur : Dates invalides.");
            }
    
            $reservationModel = new ReservationModel();
            $reservationId = $reservationModel->addReservation($userId, $annonceId, $dateDebut, $dateFin, $nbChambres);
    
            if ($reservationId) {
                header("Location: /paiement/$reservationId");
                exit();
            } else {
                echo "Erreur lors de la réservation.";
            }
        }
    }
    
}
