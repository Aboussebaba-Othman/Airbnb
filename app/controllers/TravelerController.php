<?php
namespace App\Controllers;
use Core\Controller;

class TravelerController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_role']) || strtolower($_SESSION['user_role']) !== 'voyageur') {
            $this->redirect('/login');
        }
    }

    public function index() {
        return $this->view('home/index');
    }
}