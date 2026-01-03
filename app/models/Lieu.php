<?php

require_once __DIR__ . '/../../config/database.php';

class Lieu {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->connect();
    }

    public function getAllLieux() {
        $sql = "SELECT * FROM lieu ORDER BY lib_lieu ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLieuById($idLieu) {
        $sql = "SELECT * FROM lieu WHERE id_lieu = :id_lieu";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_lieu', $idLieu, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
