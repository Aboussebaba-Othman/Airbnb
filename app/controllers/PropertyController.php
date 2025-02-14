<?php

namespace App\Controllers;

use Core\Controller;
use App\models\Property;
use Core\Session;

class PropertyController extends Controller {
    private $propertyModel;
    protected Session $session;

    public function __construct() {
        parent::__construct();
        $this->propertyModel = new Property();
        $this->session = Session::getInstance();
    }

    public function index() {
        $ownerId = $this->session->get('user_id'); 

        $annonces = $this->propertyModel->findByOwner($ownerId);

        return $this->view('owner/property/index', ['annonces' => $annonces]);
    }

    public function create() {
        return $this->view('property/create');
    }

    public function store() {
        if ($this->isPost()) {
            $data = $this->getBody();
            $data['owner_id'] = $this->session->get('user_id');
            $this->propertyModel->createAnnonce($data);
            $this->redirect('owner/property/index');
        }
    }

    public function edit($id) {
        $annonce = $this->propertyModel->find($id);
        return $this->view('property/edit', ['annonce' => $annonce]);
    }

    public function update($id) {
        if ($this->isPost()) {
            $data = $this->getBody();
            $this->propertyModel->updateAnnonce($id, $data);
            $this->redirect('owner/property/index');
        }
    }

    public function delete($id) {
        $this->propertyModel->deleteAnnonce($id);
        $this->redirect('owner/property/index');
    }

}