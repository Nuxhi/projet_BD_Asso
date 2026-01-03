<?php
/**
 * Modèle Section
 * Gère les opérations sur les sections et les bénévoles associés
 */

require_once __DIR__ . '/../../config/database.php';

class Section {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->connect();
    }

    /**
     * Récupère toutes les sections avec leur référent
     * @return array Liste des sections
     */
    public function getAllSections() {
        $sql = "SELECT s.*, b.nom_ben, b.pnom_ben, b.email_ben, b.tel_ben
                FROM section s
                JOIN benevole b ON s.id_ben_referent = b.id_ben
                ORDER BY s.lib_section ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une section par son code
     * @param string $cdSection Code de la section
     * @return array|false Données de la section ou false
     */
    public function getSectionByCode($cdSection) {
        $sql = "SELECT s.*, b.nom_ben, b.pnom_ben, b.email_ben, b.tel_ben
                FROM section s
                JOIN benevole b ON s.id_ben_referent = b.id_ben
                WHERE s.cd_section = :cd_section";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les bénévoles d'une section avec leurs rôles
     * @param string $cdSection Code de la section
     * @return array Liste des bénévoles de la section
     */
    public function getBenevolesBySection($cdSection) {
        $sql = "SELECT b.*, ap.role, 
                       CASE WHEN s.id_ben_referent = b.id_ben THEN 1 ELSE 0 END as is_referent
                FROM benevole b
                JOIN appartenir ap ON b.id_ben = ap.id_ben
                JOIN section s ON s.cd_section = ap.cd_section
                WHERE ap.cd_section = :cd_section
                ORDER BY is_referent DESC, b.nom_ben ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les bénévoles disponibles
     * @return array Liste des bénévoles
     */
    public function getAllBenevoles() {
        $sql = "SELECT * FROM benevole ORDER BY nom_ben ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un code de section existe déjà
     * @param string $cdSection Code de la section
     * @return bool True si existe, False sinon
     */
    public function sectionExists($cdSection) {
        $sql = "SELECT COUNT(*) FROM section WHERE cd_section = :cd_section";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Ajoute une nouvelle section
     * @param string $cdSection Code de la section
     * @param string $libSection Libellé de la section
     * @param string $dateDebSaison Date de début de saison
     * @param string $dateFinSaison Date de fin de saison
     * @param int $idBenReferent ID du bénévole référent
     * @return bool Succès de l'insertion
     */
    public function addSection($cdSection, $libSection, $dateDebSaison, $dateFinSaison, $idBenReferent) {
        $sql = "INSERT INTO section (cd_section, lib_section, date_deb_saison, date_fin_saison, id_ben_referent) 
                VALUES (:cd_section, :lib_section, :date_deb_saison, :date_fin_saison, :id_ben_referent)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->bindParam(':lib_section', $libSection, PDO::PARAM_STR);
        $stmt->bindParam(':date_deb_saison', $dateDebSaison, PDO::PARAM_STR);
        $stmt->bindParam(':date_fin_saison', $dateFinSaison, PDO::PARAM_STR);
        $stmt->bindParam(':id_ben_referent', $idBenReferent, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    /**
     * Vérifie si un bénévole appartient déjà à une section
     * @param int $idBen ID du bénévole
     * @param string $cdSection Code de la section
     * @return bool True si appartient, False sinon
     */
    public function benevoleAppartientSection($idBen, $cdSection) {
        $sql = "SELECT COUNT(*) FROM appartenir WHERE id_ben = :id_ben AND cd_section = :cd_section";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_ben', $idBen, PDO::PARAM_INT);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Ajoute un bénévole à une section avec un rôle
     * @param int $idBen ID du bénévole
     * @param string $cdSection Code de la section
     * @param string $role Rôle du bénévole
     * @return bool Succès de l'insertion
     */
    public function addBenevoleToSection($idBen, $cdSection, $role) {
        $sql = "INSERT INTO appartenir (id_ben, cd_section, role) VALUES (:id_ben, :cd_section, :role)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_ben', $idBen, PDO::PARAM_INT);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Modifie le rôle d'un bénévole dans une section
     * @param int $idBen ID du bénévole
     * @param string $cdSection Code de la section
     * @param string $role Nouveau rôle
     * @return bool Succès de la mise à jour
     */
    public function updateBenevoleRole($idBen, $cdSection, $role) {
        $sql = "UPDATE appartenir SET role = :role WHERE id_ben = :id_ben AND cd_section = :cd_section";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':id_ben', $idBen, PDO::PARAM_INT);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Récupère les bénévoles qui n'appartiennent pas encore à une section donnée
     * @param string $cdSection Code de la section
     * @return array Liste des bénévoles disponibles
     */
    public function getBenevolesNotInSection($cdSection) {
        $sql = "SELECT b.* FROM benevole b
                WHERE b.id_ben NOT IN (
                    SELECT ap.id_ben FROM appartenir ap WHERE ap.cd_section = :cd_section
                )
                ORDER BY b.nom_ben ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cd_section', $cdSection, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
