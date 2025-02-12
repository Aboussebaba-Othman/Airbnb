<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;
use Core\Validation;
use App\Services\SocialAuthService;

class AuthController extends Controller {
    protected User $userModel;
    protected Session $session;
    protected Validation $validation;
    private $socialAuth;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = new Session();
        $this->validation = new Validation();
        $this->socialAuth = new SocialAuthService();
    }

    public function googleAuth() {
        $authUrl = $this->socialAuth->getGoogleAuthUrl();
        $this->redirect($authUrl);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];
    
            $user = $this->userModel->findByEmail($data['email']);
            
            error_log("User data: " . print_r($user, true));
    
            if (!$user || !password_verify($data['password'], $user['password'])) {
                $this->session->setFlash('error', 'Email ou mot de passe incorrect');
                return $this->view('auth/login', [
                    'email' => $data['email']
                ]);
            }
    
            $this->session->setUserData($user);
            
            
            error_log("Role in session: " . $this->session->getUserRole());
            
            $this->redirectBasedOnRole();
            return;
        }
    
        return $this->view('auth/login');
    }

    protected function redirectBasedOnRole() {
        $role = strtolower($this->session->getUserRole());
        
        error_log("Role de l'utilisateur : " . $role);

        switch($role) {
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
                var_dump("test");
                exit;
                error_log("Role non reconnu : " . $role);
                $this->redirect('/');
        }
    }

    public function logout() {
        $this->session->destroy();
        $this->session->setFlash('success', 'Vous avez été déconnecté');
        $this->redirect('/login');
    }
    





    public function register() {
        if ($this->session->isLoggedIn()) {
            $this->redirectBasedOnRole();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? '',
                'role' => $_POST['role'] ?? 'voyageur', 
                'description' => $_POST['description'] ?? ''
            ];

            $rules = [
                'username' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6'],
                'password_confirm' => ['required'],
                'role' => ['required']
            ];

            if (!$this->validation->validate($data, $rules)) {
                return $this->view('auth/register', [
                    'errors' => $this->validation->getErrors(),
                    'old' => $data
                ]);
            }

            if ($data['password'] !== $data['password_confirm']) {
                $this->session->setFlash('error', 'Les mots de passe ne correspondent pas');
                return $this->view('auth/register', ['old' => $data]);
            }

            if ($this->userModel->findByEmail($data['email'])) {
                $this->session->setFlash('error', 'Cet email est déjà utilisé');
                return $this->view('auth/register', ['old' => $data]);
            }

            $photo = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $photo = $this->handlePhotoUpload($_FILES['photo']);
                if (!$photo) {
                    $this->session->setFlash('error', 'Erreur lors de l\'upload de la photo');
                    return $this->view('auth/register', ['old' => $data]);
                }
            }

            $userData = [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role_id' => $this->getRoleId($data['role']),
                'photo' => $photo,
                'description' => $data['description']
            ];

            if ($this->userModel->create($userData)) {
                $this->session->setFlash('success', 'Compte créé avec succès. Vous pouvez maintenant vous connecter.');
                $this->redirect('/login');
            } else {
                $this->session->setFlash('error', 'Erreur lors de la création du compte');
                return $this->view('auth/register', ['old' => $data]);
            }
        }

        return $this->view('auth/register');
    }

    protected function handlePhotoUpload($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024; 

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $uploadDir = 'assets/uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $fileName;
        }

        return false;
    }
    protected function getRoleId($roleName) {
        $roles = [
            'admin' => 1,       
            'voyageur' => 2,     
            'proprietaire' => 3   
        ];

        return $roles[strtolower($roleName)] ?? 2;
    }



    public function googleCallback() {
        try {
            $userData = $this->socialAuth->handleGoogleCallback($_GET['code']);
            
            $user = $this->userModel->findByEmail($userData['email']);
            
            if (!$user) {
                $this->userModel->create([
                    'username' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => bin2hex(random_bytes(32)), 
                    'role_id' => 2, 
                    'photo' => $userData['picture']
                ]);
                $user = $this->userModel->findByEmail($userData['email']);
            }

            $this->session->setUserData($user);
            $this->redirectBasedOnRole();

        } catch (\Exception $e) {
            $this->session->setFlash('error', 'Erreur lors de la connexion avec Google');
            $this->redirect('/login');
        }
    }

    public function facebookAuth() {
        $authUrl = $this->socialAuth->getFacebookAuthUrl();
        $this->redirect($authUrl);
    }

    public function facebookCallback() {
        try {
            $userData = $this->socialAuth->handleFacebookCallback($_GET['code']);
        } catch (\Exception $e) {
            $this->session->setFlash('error', 'Erreur lors de la connexion avec Facebook');
            $this->redirect('/login');
        }
    }

   
}