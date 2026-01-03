<?php

class Database {
    
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct(){
        //Remplissage attributs avec les infos du fichier .env.local
        $file = __DIR__ . '/../.env.local';

        if (!file_exists($file)) {
            throw new Exception("Fichier $file introuvable.");
        }

        $lines = file($file);

        if (count($lines) < 4) {
            throw new Exception("Le fichier .env.local doit contenir au moins 4 lignes non vides");
        }

        $this->host     = trim(explode('=', $lines[0], 2)[1]);
        $this->db_name  = trim(explode('=', $lines[1], 2)[1]);
        $this->username = trim(explode('=', $lines[2], 2)[1]);
        $this->password = trim(explode('=', $lines[3], 2)[1]);

        if ($this->host === '' || $this->db_name === '' || $this->username === '' || $this->password === '') {
            throw new Exception(".env.local erroner, verifier les valeurs des attributs de connexions à la BD");
        }
    }

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        } catch(PDOException $e) {
            throw new Exception('Erreur de connexion : ' . $e->getMessage());
        }

        return $this->conn;
    }
}
?>