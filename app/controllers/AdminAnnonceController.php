<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Annonce;
use Core\Session;

class AdminAnnonceController extends Controller {
    private $annonceModel;
    protected $session;

    public function __construct() {
        parent::__construct();
        $this->session = Session::getInstance();
        if (!$this->session->isLoggedIn() || strtolower($this->session->getUserRole()) !== 'admin') {
            $this->redirect('/login');
        }
        $this->annonceModel = new Annonce();
    }
     public function index() {
        $annonceModel = new AnnonceModel();
        $annonces = $annonceModel->getAll(); 
        View::render('annonces.twig', ['annonces' => $annonces]);
    }

    public function validation() {
        $annonces = $this->annonceModel->getPendingAnnonces();
        return $this->view('admin/validation', [
            'annonces' => $annonces,
            'title' => 'Validation des Annonces'
        ]);
    }

    public function toggleValidation($id) {
        $annonce = $this->annonceModel->find($id);
        
        if (!$annonce) {
            $this->session->setFlash('error', 'Annonce non trouvée');
            $this->redirect('/admin/validation');
            return;
        }

        $newStatus = $annonce['validate'] === 'valider' ? 'nonValider' : 'valider';
        
        if ($this->annonceModel->updateValidation($id, $newStatus)) {
            $message = $newStatus === 'valider' ? 'validée' : 'invalidée';
            $this->session->setFlash('success', "Annonce $message avec succès");
        } else {
            $this->session->setFlash('error', 'Erreur lors de la validation');
        }

        $this->redirect('/admin/validation');
    }
}