<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return $this->view('auth/login', [
                    'error' => 'Email et mot de passe requis'
                ]);
            }

            $user = $this->userModel->findByEmail($email);

            if (!$user) {
                return $this->view('auth/login', [
                    'error' => 'Email ou mot de passe incorrect'
                ]);
            }

            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role_title'];
                $_SESSION['username'] = $user['username'];

                switch(strtolower($user['role_title'])) {
                    case 'admin':
                        $this->redirect('/admin/dashboard');
                        break;
                    case 'proprietaire':
                        $this->redirect('/owner/dashboard');
                        break;
                    case 'voyageur':
                        $this->redirect('/owner/dashboard');
                        break;
                    default:
                        $this->redirect('/');
                }
            }

            return $this->view('auth/login', [
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }

        return $this->view('auth/login');
    }
}