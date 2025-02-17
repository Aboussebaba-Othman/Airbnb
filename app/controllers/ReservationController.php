<?php

namespace App\controllers;

use App\models\ReservationModel;
use Core\View;

class ReservationController
{

    public function getAnnonceReserve($id)
    {
        
        $reservationModel = new ReservationModel();
        $annonce = $reservationModel->getAnnonceById($id);
        if ($annonce) {  
            View::render('reserver.twig', ['annonce' => $annonce]);
        } else {
            echo "Annonce not found";
        }
    }

    public function reserver() {
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = 4;

            if (!isset($_POST['annonce_id'], $_POST['datedebut'], $_POST['datefin'], $_POST['nbVoyageurs'])) {
                die("Erreur : Données invalides.");
                var_dump('error');
                
            }
    
            $annonceId = intval($_POST['annonce_id']);
            $dateDebut = trim($_POST['datedebut']);
            $dateFin = trim($_POST['datefin']);
            $nbVoyageurs = intval($_POST['nbVoyageurs']);

            print_r($userId );
            echo '<br>';
            print_r($annonceId);
            echo '<br>';
            print_r($dateDebut);
            echo '<br>';
            print_r($dateFin);
            echo '<br>';
            print_r($nbVoyageurs);
         

          
            if (empty($dateDebut) || empty($dateFin) || $dateDebut >= $dateFin) {
                die("Erreur : Dates invalides.");
            }
    
            $reservationModel = new ReservationModel();
            $reservationId = $reservationModel->addReservation($userId, $annonceId, $dateDebut, $dateFin, $nbVoyageurs);
    
            if ($reservationId) {
                header("Location: /paiement/$reservationId");
                exit();
            } else {
                echo "Erreur lors de la réservation.";
            }
        }
    }
    
}