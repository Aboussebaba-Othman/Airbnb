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
        $reservationsThisMonth = $this->propertyModel->getReservationsThisMonth($ownerId);
        $revenueThisMonth = $this->propertyModel->getRevenueThisMonth($ownerId);
        $occupancyRateThisMonth = $this->propertyModel->getOccupancyRateThisMonth($ownerId);

        return $this->view('owner/property/index', [
            'annonces' => $annonces,
            'reservationsThisMonth' => $reservationsThisMonth,
            'revenueThisMonth' => $revenueThisMonth,
            'occupancyRateThisMonth' => $occupancyRateThisMonth
    ]);
    }

    public function create() {
        try {
            return $this->view('owner/property/create');
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }

    }

    public function store() {
        try {
            if ($this->isPost()) {
                $data = $this->getBody();
    
                $uploadDir = '..//public/uploads/logement/';
                
                if (!is_writable($uploadDir)) {
                    throw new \Exception("Le dossier d'upload n'est pas accessible en écriture.");
                }
    
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
                    $uploadFilePath = $uploadDir . $fileName;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilePath)) {
                        $data['photo'] = '/uploads/logement/' . $fileName;
                    } else {
                        throw new \Exception("Erreur lors de l'upload de l'image.");
                    }
                } else {
                    $data['photo'] = null;
                }
    
                $data['owner_id'] = $this->session->get('user_id');
                $this->propertyModel->createAnnonce($data);
                $this->redirect('index');
            }
        } catch (\Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
    

    public function edit($id) {
        try {
            $annonce = $this->propertyModel->find($id);
            return $this->view('owner/property/edit', ['annonce' => $annonce]);
        } catch (\Exception $e) {
            echo 'Erreur PDO: ' . $e->getMessage();
        }
    }

    public function update($id) {
        if ($this->isPost()) {
            $data = $this->getBody();
            $this->propertyModel->updateAnnonce($id, $data);
            $this->redirect('/property/index');
        }
    }

    public function delete($id) {
        $this->propertyModel->deleteAnnonce($id);
        $this->redirect('/property/index');
    }



}