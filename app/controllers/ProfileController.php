<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Validation;
use App\Models\User;

class ProfileController extends Controller {
    protected User $userModel;
    protected Validation $validation;
    protected Session $session;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User();
        $this->session = Session::getInstance();
        $this->validation = new Validation();

        // Ensure user is logged in
        if (!$this->session->isLoggedIn()) {
            $this->redirect('/login');
        }
    }

    public function edit() {
        // Get current user's ID from session
        $userId = $this->session->get('user_id');
        
        // Fetch user details
        $user = $this->userModel->find($userId);

        // Render edit profile view
        $this->view('profile/edit', [
            'user' => $user,
            'layout' => 'main'
        ]);
    }

    public function update() {
        // Ensure it's a POST request
        if (!$this->isPost()) {
            $this->redirect('/profile/edit');
        }

        // Get current user's ID from session
        $userId = $this->session->get('user_id');

        // Get form data
        $data = $this->getBody();

        // Add user ID to data for validation and update
        $data['user_id'] = $userId;

        // Validate profile update
        if ($error = $this->validateProfileUpdate($data)) {
            return $error;
        }

        // Process photo upload if present
        $photo = $this->processPhoto();
        if (is_string($photo) === false && $photo !== null) {
            $this->session->setFlash('error', 'Erreur lors de l\'upload de la photo');
            return $this->view('profile/edit', [
                'user' => $this->userModel->find($userId),
                'old' => $data
            ]);
        }

        // Prepare update data
        $updateData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'description' => $data['description'] ?? '',
        ];

        // Add photo to update data if a new photo was uploaded
        if ($photo) {
            $updateData['photo'] = $photo;
        }

        // Attempt to update user profile
        if ($this->userModel->update($userId, $updateData)) {
            $this->session->setFlash('success', 'Profil mis à jour avec succès');
            
            // Refresh user data in session
            $updatedUser = $this->userModel->find($userId);
            $this->session->setUserData($updatedUser);

            $this->redirect('/profile/edit');
        }

        $this->session->setFlash('error', 'Erreur lors de la mise à jour du profil');
        return $this->view('profile/edit', [
            'user' => $this->userModel->find($userId),
            'old' => $data
        ]);
    }

    private function validateProfileUpdate($data) {
        $rules = [
            'username' => ['required'],
            'email' => ['required', 'email'],
        ];

        if (!$this->validation->validate($data, $rules)) {
            return $this->view('profile/edit', [
                'errors' => $this->validation->getErrors(),
                'user' => $this->userModel->find($data['user_id']),
                'old' => $data
            ]);
        }

        // Check if email is already in use by another user
        $existingUser = $this->userModel->findByEmail($data['email']);
        if ($existingUser && $existingUser['id'] != $data['user_id']) {
            $this->session->setFlash('error', 'Cet email est déjà utilisé');
            return $this->view('profile/edit', [
                'user' => $this->userModel->find($data['user_id']),
                'old' => $data
            ]);
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
}