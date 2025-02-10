<?php
namespace App\Controllers;

use Core\Controller;

class DashboardController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
            $this->redirect('/login');
        }
    }

    public function index() {
        return $this->view('admin/dashboard', [
            'title' => 'Dashboard Admin'
        ]);
    }
}