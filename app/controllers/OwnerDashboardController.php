<?php
namespace App\Controllers;

use Core\Controller;

class OwnerDashboardController extends Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'proprietaire') {
            $this->redirect('/login');
        }
    }

    public function index() {
        return $this->view('owner/dashboard', [
            'title' => 'Dashboard Propriétaire'
        ]);
    }
}