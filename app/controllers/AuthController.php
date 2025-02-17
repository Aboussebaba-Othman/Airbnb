<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;
use Core\Validation;
use App\Services\SocialAuthService;

class AuthController extends Controller {
    protected User $userModel;
    protected Validation $validation;
    protected Session $session;
    // private SocialAuthService $socialAuth;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = Session::getInstance(); 
        $this->validation = new Validation();
        // $this->socialAuth = new SocialAuthService();
    }

    public function googleAuth() {
        $authUrl = $this->socialAuth->getGoogleAuthUrl();
        $this->redirect($authUrl);
    }

    public function login() {
        if ($this->isPost()) {
            $data = $this->getBody();
            
            $user = $this->userModel->findByEmail($data['email']);
            
            if (!$user || !password_verify($data['password'], $user['password'])) {
                $this->session->setFlash('error', 'Email ou mot de passe incorrect');
                return $this->view('auth/login', [
                    'email' => $data['email']
                ]);
            }
    
            $this->session->regenerate();
            $this->session->setUserData($user);
            $this->redirectBasedOnRole();
            return;
        }
    
        return $this->view('auth/login');
    }

    protected function redirectBasedOnRole() {
        $role = strtolower($this->session->getUserRole());

        switch($role) {
            case 'admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'proprietaire':
                $this->redirect('/property/index');
                $this->redirect('/property/index');
                break;
            case 'voyageur':
                $this->redirect('/traveler/dashboard');
                break;
            default:
                error_log("Role non reconnu : " . $role);
                $this->redirect('/');
        }
    }

    public function logout() {
        $this->session->destroy();
        $this->redirect('/login');
    }

    public function register() {
        if ($this->session->isLoggedIn()) {
            $this->redirectBasedOnRole();
        }
    
        if ($this->isPost()) {
            $data = $this->getBody();
            
            $data['description'] = $data['description'] ?? '';
            $data['role'] = $data['role'] ?? 'voyageur';
    
            if ($error = $this->validateRegistration($data)) {
                return $error;
            }
    
            $photo = $this->processPhoto();
            if (is_string($photo) === false && $photo !== null) {
                return $this->view('auth/register', [
                    'error' => 'Erreur lors de l\'upload de la photo',
                    'old' => $data
                ]);
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
                return $this->redirect('/login');
            }
    
            $this->session->setFlash('error', 'Erreur lors de la création du compte');
            return $this->view('auth/register', ['old' => $data]);
        }
    
        return $this->view('auth/register');
    }
    
    private function validateRegistration($data) {
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
    
        return false;
    }
    
    private function processPhoto() {
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
            return null;
        }
    
        $config = [
            'maxSize' => 5 * 1024 * 1024,
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/jpg'],
            'uploadDir' => 'assets/uploads/profiles/'
        ];
    
        if (!in_array($_FILES['photo']['type'], $config['allowedTypes'])) {
            return false;
        }
    
        if ($_FILES['photo']['size'] > $config['maxSize']) {
            return false;
        }
    
        if (!is_dir($config['uploadDir'])) {
            mkdir($config['uploadDir'], 0777, true);
        }
    
        $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $destination = $config['uploadDir'] . $fileName;
    
        return move_uploaded_file($_FILES['photo']['tmp_name'], $destination) ? $fileName : false;
    }
    
    private function getRoleId($roleName) {
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
            
            if ($user) {
                $this->session->regenerate();
                $this->session->setUserData($user);
                $this->redirectBasedOnRole();
            } else {
                $this->session->set('temp_google_data', [
                    'email' => $userData['email'],
                    'name' => $userData['name'],
                    'picture' => $userData['picture']
                ]);
                
                $this->redirect('/auth/complete-registration');
            }
        } catch (\Exception $e) {
            $this->session->setFlash('error', 'Erreur lors de la connexion avec Google');
            $this->redirect('/login');
        }
    }

    // public function completeRegistration() {
    //     $tempData = $this->session->get('temp_google_data') ?? $this->session->get('temp_facebook_data');
        
    //     if (!$tempData) {
    //         $this->redirect('/login');
    //     }
    
        if ($this->isPost()) {
            $data = $this->getBody();
            $data = [
                'role' => $data['role'] ?? '',
                'password' => $data['password'] ?? '',
                'password_confirm' => $data['password_confirm'] ?? ''
            ];
    
    //         $rules = [
    //             'role' => ['required'],
    //             'password' => ['required', 'min:6'],
    //             'password_confirm' => ['required']
    //         ];
    
            if (!$this->validation->validate($data, $rules)) {
                return $this->view('auth/complete-registration', [
                    'errors' => $this->validation->getErrors(),
                    'socialData' => $tempData 
                ]);
            }
    
            if ($data['password'] !== $data['password_confirm']) {
                $this->session->setFlash('error', 'Les mots de passe ne correspondent pas');
                return $this->view('auth/complete-registration', [
                    'socialData' => $tempData
                ]);
            }    
            $userData = [
                'username' => $tempData['name'],
                'email' => $tempData['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role_id' => $this->getRoleId($data['role']),
                'photo' => $tempData['picture']
            ];
    
    //         if ($this->userModel->create($userData)) {
    //             $this->session->remove('temp_google_data');
    //             $this->session->remove('temp_facebook_data');
                
                $user = $this->userModel->findByEmail($tempData['email']);
                // Add session regeneration before setting user data
                $this->session->regenerate();
                $this->session->setUserData($user);
                
    //             $this->session->setFlash('success', 'Compte créé avec succès');
    //             $this->redirectBasedOnRole();
    //         } else {
    //             $this->session->setFlash('error', 'Erreur lors de la création du compte');
    //             return $this->view('auth/complete-registration');
    //         }
    //     }
    
    //     return $this->view('auth/complete-registration', [
    //         'socialData' => $tempData
    //     ]);
    // }
    // public function facebookAuth() {
    //     $authUrl = $this->socialAuth->getFacebookAuthUrl();
    //     $this->redirect($authUrl);
    // }
    
    // public function facebookCallback() {
    //     try {
    //         if (!isset($_GET['code'])) {
    //             throw new \Exception('Code Facebook manquant');
    //         }
    
    //         $userData = $this->socialAuth->handleFacebookCallback($_GET['code']);
            
    //         $user = $this->userModel->findByEmail($userData['email']);
            
    //         if ($user) {
    //             $this->session->setUserData($user);
    //             $this->redirectBasedOnRole();
    //         } else {
    //             $this->session->set('temp_facebook_data', [
    //                 'email' => $userData['email'],
    //                 'name' => $userData['name'],
    //                 'picture' => $userData['picture']
    //             ]);
                
    //             $this->redirect('/auth/complete-registration');
    //         }
    
    //     } catch (\Exception $e) {
    //         $this->session->setFlash('error', 'Erreur lors de la connexion avec Facebook');
    //         $this->redirect('/login');
    //     }
    // }

   
}