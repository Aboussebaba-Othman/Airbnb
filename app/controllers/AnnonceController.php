<?php

namespace App\controllers;

use App\models\AnnonceModel;
use Core\View;

class AnnonceController {

    public function home(){
        $annonceModel = new AnnonceModel();
        $annonces = $annonceModel->getAll(); 
        View::render('home/index.twig');
    }
    public function searchannonce(){
        header('Content-Type: application/json');
        if(isset($_GET["s"]) || !empty($_GET["s"])){
            $annonceModel = new AnnonceModel();
            $annonces = $annonceModel->getAllbySearch($_GET["s"]); 
            echo json_encode($annonces);
        }
        else if(isset($_GET["f"]) || !empty($_GET["f"])){
            $annonceModel = new AnnonceModel();
            $annonces = $annonceModel->getAllbySearch($_GET["f"]); 
            echo json_encode($annonces);
        }
        else{
            $annonceModel = new AnnonceModel();
            $annonces = $annonceModel->getAll(); 
            echo json_encode($annonces);
        }
    }
}