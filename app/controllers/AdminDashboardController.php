<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\Annonce;
use App\Models\User;

class AdminDashboardController extends Controller {
    private $annonceModel;
    private $userModel;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'admin') {
            $this->redirect('/login');
        }
        
        $this->annonceModel = new Annonce();
        $this->userModel = new User();
    }

    public function index() {
        $stats = array_merge(
            $this->annonceModel->getDashboardStats(),
            ['total_users' => $this->userModel->count()]
        );

        return $this->view('admin/dashboard', [
            'stats' => $stats,
            'annonces' => $this->annonceModel->getAllAnnonces(),
            'title' => 'Tableau de Bord Admin'
        ]);
    }
    
}