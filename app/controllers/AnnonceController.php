<?php

namespace App\controllers;

use App\models\AnnonceModel;
use Core\View\View;

class AnnonceController {
    public function index() {
        $annonceModel = new AnnonceModel();
        $annonces = $annonceModel->getAll(); 

        View::render('annonces.twig', ['annonces' => $annonces]);
    }
}
