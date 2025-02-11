<?php

namespace App\controllers;
use App\models\ReservationModel;
use App\Models\PaiementModel;
use Core\View;

class ReservationController{
    public function reserver() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id']; 
        $logement_id = $_POST['logement_id'];
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datefin'];

        $reservationModel = new ReservationModel();
        $reservation_id = $reservationModel->fairReservation($user_id, $logement_id, $datedebut, $datefin);

        echo json_encode(["success" => true, "reservation_id" => $reservation_id]);
        exit;
    }
}


public function payer() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $reservation_id = $_POST['reservation_id'];
        $montant = $_POST['montant'];
        $methode = "PayPal"; 

        $paiementModel = new PaiementModel();
        $paiementModel->enregistrerPaiement($reservation_id, $_SESSION['user_id'], $montant, $methode);

        $reservationModel = new ReservationModel();
        $reservationModel->updateStatus($reservation_id, "confirmée");

        echo json_encode(["success" => true]);
        exit;
    }

}
}