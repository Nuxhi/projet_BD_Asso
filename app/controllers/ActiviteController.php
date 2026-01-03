<?php
/**
 * ActiviteController
 * Gère les activités et les inscriptions
 */

require_once __DIR__ . '/../models/Activite.php';
require_once __DIR__ . '/../models/Lieu.php';

class ActiviteController {

    /**
     * Affiche la liste des activités avec filtres
     */
    public function activiteList() {
        $model = new Activite();
        
        // Récupération des filtres depuis les paramètres GET
        $sectionsFilter = isset($_GET['sections']) && !empty($_GET['sections']) ? $_GET['sections'] : null;
        $joursFilter = isset($_GET['jours']) && !empty($_GET['jours']) ? $_GET['jours'] : null;
        $heureMinFilter = isset($_GET['heure_min']) && !empty($_GET['heure_min']) ? $_GET['heure_min'] : null;
        $heureMaxFilter = isset($_GET['heure_max']) && !empty($_GET['heure_max']) ? $_GET['heure_max'] : null;
        
        // Si des filtres sont présents, utiliser la méthode filtrée
        if ($sectionsFilter || $joursFilter || $heureMinFilter || $heureMaxFilter) {
             $activites = $model->getActivitesFiltered($sectionsFilter, $joursFilter, $heureMinFilter, $heureMaxFilter);
        } else {
            $activites = $model->getAllActivite();
        }

        $sections = $model->getUsedSections();
        
        // Ajouter le nombre d'inscrits pour chaque activité
        foreach ($activites as &$act) {
            $act['nb_inscrits'] = $model->countInscrits($act['id_activ']);
            $act['places_restantes'] = $act['capacite'] - $act['nb_inscrits'];
            $act['est_complete'] = $act['places_restantes'] <= 0;
        }
        unset($act); // Bonne pratique après une référence dans foreach

        require_once __DIR__.'/../views/activite/activiteList.php';
    }

    /**
     * Affiche le détail d'une activité avec la liste des inscrits
     */
    public function activiteDetail() {
        $idActiv = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($idActiv <= 0) {
            require_once __DIR__ . '/../views/notFound.php';
            return;
        }

        $model = new Activite();
        $activite = $model->getActiviteById($idActiv);
        
        if (!$activite) {
            require_once __DIR__ . '/../views/notFound.php';
            return;
        }

        $inscrits = $model->getInscritsActivite($idActiv);
        $nbInscrits = count($inscrits);
        $placesRestantes = $activite['capacite'] - $nbInscrits;
        $estComplete = $placesRestantes <= 0;

        require_once __DIR__ . '/../views/activite/activiteDetail.php';
    }

    /**
     * Affiche le formulaire d'ajout d'activité et traite la soumission
     */
    public function addActivite() {
        $model = new Activite();
        $sections = $model->getAllSections();
        $lieux = $model->getAllLieux();
        
        $message = '';
        $messageType = '';
        $formData = [
            'lib_activ' => '',
            'desc_activ' => '',
            'jour' => '',
            'h_deb' => '',
            'duree_min' => '',
            'tarif' => '',
            'cd_section_activ' => '',
            'id_lieu_activ' => ''
        ];
        
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données
            $formData['lib_activ'] = isset($_POST['lib_activ']) ? trim($_POST['lib_activ']) : '';
            $formData['desc_activ'] = isset($_POST['desc_activ']) ? trim($_POST['desc_activ']) : '';
            $formData['jour'] = isset($_POST['jour']) ? trim($_POST['jour']) : '';
            $formData['h_deb'] = isset($_POST['h_deb']) ? trim($_POST['h_deb']) : '';
            $formData['duree_min'] = isset($_POST['duree_min']) ? (int)$_POST['duree_min'] : 0;
            $formData['tarif'] = isset($_POST['tarif']) ? floatval($_POST['tarif']) : 0;
            $formData['cd_section_activ'] = isset($_POST['cd_section_activ']) ? trim($_POST['cd_section_activ']) : '';
            $formData['id_lieu_activ'] = isset($_POST['id_lieu_activ']) ? (int)$_POST['id_lieu_activ'] : 0;
            
            // Validation
            $errors = [];
            
            if (empty($formData['lib_activ'])) {
                $errors[] = 'Le libellé de l\'activité est obligatoire.';
            } elseif (strlen($formData['lib_activ']) > 30) {
                $errors[] = 'Le libellé ne peut pas dépasser 30 caractères.';
            }
            
            if (strlen($formData['desc_activ']) > 150) {
                $errors[] = 'La description ne peut pas dépasser 150 caractères.';
            }
            
            if (empty($formData['jour'])) {
                $errors[] = 'Le jour est obligatoire.';
            } elseif (!in_array($formData['jour'], $jours)) {
                $errors[] = 'Le jour sélectionné n\'est pas valide.';
            }
            
            if (empty($formData['h_deb'])) {
                $errors[] = 'L\'heure de début est obligatoire.';
            } elseif (!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $formData['h_deb'])) {
                $errors[] = 'L\'heure de début n\'est pas valide.';
            }
            
            if ($formData['duree_min'] <= 0) {
                $errors[] = 'La durée doit être supérieure à 0 minutes.';
            } elseif ($formData['duree_min'] > 480) {
                $errors[] = 'La durée ne peut pas dépasser 480 minutes (8 heures).';
            }
            
            if ($formData['tarif'] < 0) {
                $errors[] = 'Le tarif ne peut pas être négatif.';
            }
            
            if (empty($formData['cd_section_activ'])) {
                $errors[] = 'La section est obligatoire.';
            }
            
            if ($formData['id_lieu_activ'] <= 0) {
                $errors[] = 'Le lieu est obligatoire.';
            }
            
            if (!empty($errors)) {
                $message = implode('<br>', $errors);
                $messageType = 'error';
            } else {
                // Obtenir le prochain ID
                $nextId = $model->getNextId();
                
                // Insertion en base
                if ($model->addActivite(
                    $nextId,
                    $formData['lib_activ'],
                    $formData['desc_activ'],
                    $formData['jour'],
                    $formData['h_deb'],
                    $formData['duree_min'],
                    $formData['tarif'],
                    $formData['cd_section_activ'],
                    $formData['id_lieu_activ']
                )) {
                    $message = 'Activité créée avec succès !';
                    $messageType = 'success';
                    // Réinitialiser le formulaire
                    $formData = [
                        'lib_activ' => '',
                        'desc_activ' => '',
                        'jour' => '',
                        'h_deb' => '',
                        'duree_min' => '',
                        'tarif' => '',
                        'cd_section_activ' => '',
                        'id_lieu_activ' => ''
                    ];
                } else {
                    $message = 'Erreur lors de la création de l\'activité.';
                    $messageType = 'error';
                }
            }
        }
        
        require_once __DIR__ . '/../views/activite/addActivite.php';
    }
}