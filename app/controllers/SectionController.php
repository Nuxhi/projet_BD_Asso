<?php
/**
 * SectionController
 * Gère les sections et les bénévoles associés
 */

require_once __DIR__ . '/../models/Section.php';

class SectionController {

    /**
     * Affiche la liste des sections
     */
    public function sectionList() {
        $model = new Section();
        $sections = $model->getAllSections();
        
        require_once __DIR__ . '/../views/section/sectionList.php';
    }

    /**
     * Affiche le détail d'une section avec ses bénévoles
     */
    public function sectionDetail() {
        $cdSection = isset($_GET['cd']) ? trim($_GET['cd']) : null;
        
        if (!$cdSection) {
            header('Location: /section-liste');
            exit;
        }

        $model = new Section();
        $section = $model->getSectionByCode($cdSection);
        
        if (!$section) {
            require_once __DIR__ . '/../views/notFound.php';
            return;
        }

        $benevoles = $model->getBenevolesBySection($cdSection);
        $benevolesDisponibles = $model->getBenevolesNotInSection($cdSection);
        
        // Traitement du formulaire d'ajout de bénévole
        $message = '';
        $messageType =  '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'add_benevole':
                        $result = $this->handleAddBenevole($model, $cdSection);
                        $message = $result['message'];
                        $messageType = $result['type'];
                        // Recharger les données
                        $benevoles = $model->getBenevolesBySection($cdSection);
                        $benevolesDisponibles = $model->getBenevolesNotInSection($cdSection);
                        break;
                    
                    case 'update_role':
                        $result = $this->handleUpdateRole($model, $cdSection);
                        $message = $result['message'];
                        $messageType = $result['type'];
                        // Recharger les données
                        $benevoles = $model->getBenevolesBySection($cdSection);
                        break;
                }
            }
        }

        require_once __DIR__ . '/../views/section/sectionDetail.php';
    }

    /**
     * Traite l'ajout d'un bénévole à une section
     */
    private function handleAddBenevole($model, $cdSection) {
        $idBen = isset($_POST['id_ben']) ? (int)$_POST['id_ben'] : 0;
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';
        
        // Validation
        if ($idBen <= 0) {
            return ['message' => 'Veuillez sélectionner un bénévole.', 'type' => 'error'];
        }
        
        if (empty($role)) {
            return ['message' => 'Veuillez indiquer une fonction.', 'type' => 'error'];
        }
        
        if (strlen($role) > 30) {
            return ['message' => 'La fonction ne peut pas dépasser 30 caractères.', 'type' => 'error'];
        }
        
        // Vérifier si le bénévole n'est pas déjà dans la section
        if ($model->benevoleAppartientSection($idBen, $cdSection)) {
            return ['message' => 'Ce bénévole appartient déjà à cette section.', 'type' => 'error'];
        }
        
        // Ajouter le bénévole
        if ($model->addBenevoleToSection($idBen, $cdSection, $role)) {
            return ['message' => 'Bénévole ajouté à la section avec succès.', 'type' => 'success'];
        } else {
            return ['message' => 'Erreur lors de l\'ajout du bénévole.', 'type' => 'error'];
        }
    }

    /**
     * Traite la modification du rôle d'un bénévole
     */
    private function handleUpdateRole($model, $cdSection) {
        $idBen = isset($_POST['id_ben']) ? (int)$_POST['id_ben'] : 0;
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';
        
        // Validation
        if ($idBen <= 0) {
            return ['message' => 'Bénévole invalide.', 'type' => 'error'];
        }
        
        if (empty($role)) {
            return ['message' => 'Veuillez indiquer une fonction.', 'type' => 'error'];
        }
        
        if (strlen($role) > 30) {
            return ['message' => 'La fonction ne peut pas dépasser 30 caractères.', 'type' => 'error'];
        }
        
        // Mettre à jour le rôle
        if ($model->updateBenevoleRole($idBen, $cdSection, $role)) {
            return ['message' => 'Fonction du bénévole mise à jour avec succès.', 'type' => 'success'];
        } else {
            return ['message' => 'Erreur lors de la mise à jour de la fonction.', 'type' => 'error'];
        }
    }

    /**
     * Affiche le formulaire d'ajout de section et traite la soumission
     */
    public function addSection() {
        $model = new Section();
        $benevoles = $model->getAllBenevoles();
        
        $message = '';
        $messageType = '';
        $formData = [
            'cd_section' => '',
            'lib_section' => '',
            'date_deb_saison' => '',
            'date_fin_saison' => '',
            'id_ben_referent' => ''
        ];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données
            $formData['cd_section'] = isset($_POST['cd_section']) ? strtoupper(trim($_POST['cd_section'])) : '';
            $formData['lib_section'] = isset($_POST['lib_section']) ? trim($_POST['lib_section']) : '';
            $formData['date_deb_saison'] = isset($_POST['date_deb_saison']) ? trim($_POST['date_deb_saison']) : '';
            $formData['date_fin_saison'] = isset($_POST['date_fin_saison']) ? trim($_POST['date_fin_saison']) : '';
            $formData['id_ben_referent'] = isset($_POST['id_ben_referent']) ? (int)$_POST['id_ben_referent'] : 0;
            
            // Validation
            $errors = [];
            
            if (empty($formData['cd_section'])) {
                $errors[] = 'Le code de section est obligatoire.';
            } elseif (strlen($formData['cd_section']) > 5) {
                $errors[] = 'Le code de section ne peut pas dépasser 5 caractères.';
            } elseif ($model->sectionExists($formData['cd_section'])) {
                $errors[] = 'Ce code de section existe déjà.';
            }
            
            if (empty($formData['lib_section'])) {
                $errors[] = 'Le nom de la section est obligatoire.';
            } elseif (strlen($formData['lib_section']) > 30) {
                $errors[] = 'Le nom de la section ne peut pas dépasser 30 caractères.';
            }
            
            if (empty($formData['date_deb_saison'])) {
                $errors[] = 'La date de début de saison est obligatoire.';
            }
            
            if (empty($formData['date_fin_saison'])) {
                $errors[] = 'La date de fin de saison est obligatoire.';
            }
            
            if (!empty($formData['date_deb_saison']) && !empty($formData['date_fin_saison'])) {
                if ($formData['date_deb_saison'] >= $formData['date_fin_saison']) {
                    $errors[] = 'La date de fin doit être postérieure à la date de début.';
                }
            }
            
            if ($formData['id_ben_referent'] <= 0) {
                $errors[] = 'Veuillez sélectionner un référent.';
            }
            
            if (!empty($errors)) {
                $message = implode('<br>', $errors);
                $messageType = 'error';
            } else {
                // Insertion en base
                if ($model->addSection(
                    $formData['cd_section'],
                    $formData['lib_section'],
                    $formData['date_deb_saison'],
                    $formData['date_fin_saison'],
                    $formData['id_ben_referent']
                )) {
                    // Ajouter automatiquement le référent à la table appartenir avec le rôle "Référent"
                    $model->addBenevoleToSection($formData['id_ben_referent'], $formData['cd_section'], 'Référent');
                    
                    $message = 'Section créée avec succès !';
                    $messageType = 'success';
                    // Réinitialiser le formulaire
                    $formData = [
                        'cd_section' => '',
                        'lib_section' => '',
                        'date_deb_saison' => '',
                        'date_fin_saison' => '',
                        'id_ben_referent' => ''
                    ];
                } else {
                    $message = 'Erreur lors de la création de la section.';
                    $messageType = 'error';
                }
            }
        }
        
        require_once __DIR__ . '/../views/section/addSection.php';
    }
}
