<?php

require_once __DIR__ . '/../../config/database.php';

class Activite {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->connect();
    }

    public function getAllActivite() {
        $sql = "SELECT a.*, s.lib_section, s.cd_section, l.lib_lieu, l.ad_lieu, l.capacite 
                FROM activite a
                JOIN section s ON a.cd_section_activ = s.cd_section
                JOIN lieu l ON a.id_lieu_activ = l.id_lieu
                ORDER BY a.jour, a.h_deb";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivitesFiltered($sections = null, $jours = null, $heureMin = null, $heureMax = null) {
        $sql = "SELECT a.*, s.lib_section, s.cd_section, l.lib_lieu, l.ad_lieu, l.capacite 
                FROM activite a
                JOIN section s ON a.cd_section_activ = s.cd_section
                JOIN lieu l ON a.id_lieu_activ = l.id_lieu
                WHERE 1=1";
        
        $params = [];

        // Filtre par sections
        if (!empty($sections)) {
            $placeholders = [];
            foreach ($sections as $key => $section) {
                $paramName = ":section_$key";
                $placeholders[] = $paramName;
                $params[$paramName] = $section;
            }
            $sql .= " AND s.lib_section IN (" . implode(',', $placeholders) . ")";
        }

        // Filtre par jours
        if (!empty($jours)) {
            $placeholders = [];
            foreach ($jours as $key => $jour) {
                $paramName = ":jour_$key";
                $placeholders[] = $paramName;
                $params[$paramName] = $jour;
            }
            $sql .= " AND a.jour IN (" . implode(',', $placeholders) . ")";
        }

        // Filtre par heure minimum
        if (!empty($heureMin)) {
            $sql .= " AND a.h_deb >= :heure_min";
            $params[':heure_min'] = $heureMin;
        }

        // Filtre par heure maximum
        if (!empty($heureMax)) {
            $sql .= " AND a.h_deb <= :heure_max";
            $params[':heure_max'] = $heureMax;
        }

        $sql .= " ORDER BY a.jour, a.h_deb";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsedSections() {
        $sql = "SELECT DISTINCT s.lib_section, s.cd_section 
                FROM section s
                JOIN activite a ON s.cd_section = a.cd_section_activ
                ORDER BY s.lib_section ASC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSections() {
        $sql = "SELECT cd_section, lib_section FROM section ORDER BY lib_section ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiviteById($idActiv) {
        $sql = "SELECT a.*, s.lib_section, s.cd_section, l.lib_lieu, l.ad_lieu, l.capacite 
                FROM activite a
                JOIN section s ON a.cd_section_activ = s.cd_section
                JOIN lieu l ON a.id_lieu_activ = l.id_lieu
                WHERE a.id_activ = :id_activ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_activ', $idActiv, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInscritsActivite($idActiv) {
        $sql = "SELECT ad.*, i.date_insc, i.remise
                FROM adherent ad
                JOIN inscrire i ON ad.num_adherent = i.num_adherent
                WHERE i.id_activ = :id_activ
                ORDER BY ad.nom_adherent ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_activ', $idActiv, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countInscrits($idActiv) {
        $sql = "SELECT COUNT(*) FROM inscrire WHERE id_activ = :id_activ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_activ', $idActiv, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getNextId() {
        $sql = "SELECT MAX(id_activ) + 1 as next_id FROM activite";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['next_id'] ?? 1;
    }

    public function addActivite($idActiv, $libActiv, $descActiv, $jour, $hDeb, $dureeMin, $tarif, $cdSectionActiv, $idLieuActiv) {
        $sql = "INSERT INTO activite (id_activ, lib_activ, desc_activ, jour, h_deb, duree_min, tarif, cd_section_activ, id_lieu_activ) 
                VALUES (:id_activ, :lib_activ, :desc_activ, :jour, :h_deb, :duree_min, :tarif, :cd_section_activ, :id_lieu_activ)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_activ', $idActiv, PDO::PARAM_INT);
        $stmt->bindParam(':lib_activ', $libActiv, PDO::PARAM_STR);
        $stmt->bindParam(':desc_activ', $descActiv, PDO::PARAM_STR);
        $stmt->bindParam(':jour', $jour, PDO::PARAM_STR);
        $stmt->bindParam(':h_deb', $hDeb, PDO::PARAM_STR);
        $stmt->bindParam(':duree_min', $dureeMin, PDO::PARAM_INT);
        $stmt->bindParam(':tarif', $tarif, PDO::PARAM_STR);
        $stmt->bindParam(':cd_section_activ', $cdSectionActiv, PDO::PARAM_STR);
        $stmt->bindParam(':id_lieu_activ', $idLieuActiv, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function getAllLieux() {
        $sql = "SELECT * FROM lieu ORDER BY lib_lieu ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}