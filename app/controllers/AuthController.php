<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;
use Core\Validation;

class AuthController extends Controller {
    protected User $userModel;
    protected Session $session;
    protected Validation $validation;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = new Session();
        $this->validation = new Validation();
    }

    public function login() {
        if ($this->session->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $rules = [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6']
            ];

            if (!$this->validation->validate($data, $rules)) {
                return $this->view('auth/login', [
                    'errors' => $this->validation->getErrors(),
                    'email' => $data['email']
                ]);
            }

            $user = $this->userModel->findByEmail($data['email']);
            if (!$user || $data['password'] !== $user['password']) {
                $this->session->setFlash('error', 'Email ou mot de passe incorrect');
                return $this->view('auth/login', [
                    'email' => $data['email']
                ]);
            }

            $this->session->setUserData($user);
            $this->redirectBasedOnRole();
            return;
        }

        return $this->view('auth/login');
    }

    protected function redirectBasedOnRole() {
        switch(strtolower($this->session->getUserRole())) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'proprietaire':
                $this->redirect('/owner/dashboard');
                break;
            case 'voyageur':
                $this->redirect('/traveler/dashboard');
                break;
            default:
                $this->redirect('/');
        }
    }

    public function logout() {
        $this->session->destroy();
        $this->session->setFlash('success', 'Vous avez été déconnecté');
        $this->redirect('/login');
    }
}