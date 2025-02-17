<?php
namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;
class UserController extends Controller {
    private $userModel;
    protected $session;

    public function __construct() {
        parent::__construct();
        $this->session = Session::getInstance();
        if (!$this->session->isLoggedIn() || strtolower($this->session->getUserRole()) !== 'admin') {
            $this->redirect('/login');
        }
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        return $this->view('admin/users', [
            'users' => $users,
            'title' => 'Gestion des Utilisateurs'
        ]);
    }

    public function delete($id) {
        if ($id == $_SESSION['user_id']) {
            $this->session->setFlash('error', 'Vous ne pouvez pas supprimer votre propre compte');
            $this->redirect('/admin/users');
            return;
        }

        if ($this->userModel->delete($id)) {
            $this->session->setFlash('success', 'Utilisateur supprimé avec succès');
        } else {
            $this->session->setFlash('error', 'Erreur lors de la suppression');
        }
        
        $this->redirect('/admin/users');
    }

    public function toggleStatus($id) {
        if ($id == $_SESSION['user_id']) {
            $this->session->setFlash('error', 'Vous ne pouvez pas bloquer votre propre compte');
            $this->redirect('/admin/users');
            return;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            $this->session->setFlash('error', 'Utilisateur non trouvé');
            $this->redirect('/admin/users');
            return;
        }

        $newStatus = ($user['status'] ?? 'active') === 'blocked' ? 'active' : 'blocked';
        
        if ($this->userModel->update($id, ['status' => $newStatus])) {
            $message = $newStatus === 'blocked' ? 'bloqué' : 'débloqué';
            $this->session->setFlash('success', "Utilisateur $message avec succès");
        } else {
            $this->session->setFlash('error', 'Erreur lors de la modification du statut');
        }

        $this->redirect('/admin/users');
    }
}