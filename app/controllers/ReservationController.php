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
            // Handle the case when the annonce doesn't exist
            echo "Annonce not found";
        }
    }
}
