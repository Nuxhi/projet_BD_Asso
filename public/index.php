<?php
require_once '../app/controllers/GlobalController.php';
require_once '../app/controllers/ActiviteController.php';
require_once '../app/controllers/SectionController.php';


$path = $_SERVER['PATH_INFO'] ?? null;

switch($path){
    case NULL:
    case "/":
        (new GlobalController())->home();
        break;
    
    // Routes pour les activités
    case "/activite-liste":
        (new ActiviteController())->activiteList();
        break;
    
    case "/activite-detail":
        (new ActiviteController())->activiteDetail();
        break;
    
    case "/activite-ajouter":
        (new ActiviteController())->addActivite();
        break;
    
    // Routes pour les sections
    case "/section-liste":
        (new SectionController())->sectionList();
        break;
    
    case "/section-detail":
        (new SectionController())->sectionDetail();
        break;
    
    case "/section-ajouter":
        (new SectionController())->addSection();
        break;

    default:
        (new GlobalController())->notFound();
}
