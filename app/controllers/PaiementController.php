<?php
namespace App\Controllers;

use App\Services\PayPalService;
use Core\View;

class PaiementController
{
    private $paypalService;

    public function __construct()
    {
        // $this->paypalService = new PayPalService();
    }

    /**
     * Affiche la page de paiement.
     *
     * @param int $reservationId
     */
    public function showPaiement($id) // @param $reservationId
    {
        // Récupérer les détails de la réservation
        $reservationModel = new \App\Models\ReservationModel();
        $reservation = $reservationModel->getReservationById($id);

        if (!$reservation) {
            die("Réservation non trouvée.");
        }

        View::render('paiement.twig', [
            'reservationId' => $id,
            'reservation' => $reservation,
        ]);
        //  View::render('paiement.twig', []);
    }

    /**
     * Initie un paiement PayPal.
     *
     * @param int $reservationId
     */
    public function initierPaiement($reservationId)
    {
        // Récupérer les détails de la réservation
        $reservationModel = new \App\Models\ReservationModel();
        $reservation = $reservationModel->getAnnonceById($reservationId);

        var_dump($reservation);
        if (!$reservation) {
            die("Réservation non trouvée.");
        }

        // Créer un paiement PayPal
        $returnUrl = "http://votresite.com/paiement/success/$reservationId";
        $cancelUrl = "http://votresite.com/paiement/cancel/$reservationId";
        $approvalLink = $this->paypalService->createPayment(
            $reservation['prix'],
            'EUR', // Devise
            "Paiement pour la réservation #$reservationId",
            $returnUrl,
            $cancelUrl
        );

        if ($approvalLink) {
            header("Location: $approvalLink");
            exit();
        } else {
            die("Erreur lors de la création du paiement.");
        }
    }

    /**
     * Gère le succès du paiement.
     *
     * @param int $reservationId
     */
    public function success($reservationId)
    {
        $paymentId = $_GET['paymentId'];
        $payerId = $_GET['PayerID'];

        // Exécuter le paiement
        if ($this->paypalService->executePayment($paymentId, $payerId)) {
            // Mettre à jour la base de données
            $paiementModel = new \App\Models\PaiementModel();
            // $paiementModel->addPaiement($reservationId, $paymentId, 'PayPal');

            // Afficher une page de succès
            View::render('paiement_success.twig', ['reservationId' => $reservationId]);
        } else {
            die("Erreur lors de l'exécution du paiement.");
        }
    }

    /**
     * Gère l'annulation du paiement.
     *
     * @param int $reservationId
     */
    public function cancel($reservationId)
    {
        View::render('paiement_cancel.twig', ['reservationId' => $reservationId]);
    }
}