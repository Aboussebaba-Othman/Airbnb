<?php
namespace App\Controllers;
use Core\Controller;

class HomeController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if (isset($_SESSION['user_role'])) {
            switch(strtolower($_SESSION['user_role'])) {
                case 'admin':
                    $this->redirect('/admin/dashboard');
                    break;
                case 'proprietaire':
                    $this->redirect('/property/index');
                    break;
                case 'voyageur':
                    $this->redirect('/annonces');
                    break;
            }
        }
        return $this->view('home/index', [
            'title' => 'Accueil'

        ]);
    }
}