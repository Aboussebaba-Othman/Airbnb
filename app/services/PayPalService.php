<?php
namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;

class PayPalService
{
    private $apiContext;

    public function __construct()
    {
        $paypalConfig = require 'config/paypal.php';
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($paypalConfig['client_id'], $paypalConfig['client_secret'])
        );
        $this->apiContext->setConfig(['mode' => $paypalConfig['mode']]);
    }

    /**
     * Crée un paiement PayPal.
     *
     * @param float $montant
     * @param string $devise
     * @param string $description
     * @param string $returnUrl
     * @param string $cancelUrl
     * @return string|null
     */
    public function createPayment($montant, $devise, $description, $returnUrl, $cancelUrl)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency($devise)
               ->setTotal($montant);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setDescription($description);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl)
                     ->setCancelUrl($cancelUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
            return $payment->getApprovalLink();
        } catch (\Exception $e) {
            error_log("Erreur lors de la création du paiement PayPal : " . $e->getMessage());
            return null;
        }
    }

    /**
     * Exécute un paiement PayPal après approbation de l'utilisateur.
     *
     * @param string $paymentId
     * @param string $payerId
     * @return bool
     */
    public function executePayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $payment->execute($execution, $this->apiContext);
            return true;
        } catch (\Exception $e) {
            error_log("Erreur lors de l'exécution du paiement PayPal : " . $e->getMessage());
            return false;
        }
    }
}