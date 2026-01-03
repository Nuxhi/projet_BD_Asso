<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS adherent (
        num_adherent CHAR(5) PRIMARY KEY,
        nom_adherent VARCHAR(30),
        pnom_adherent VARCHAR(30),
        date_nais DATE,
        ad_adherent VARCHAR(50),
        cp_adherent CHAR(5),
        ville_adherent VARCHAR(20),
        tel CHAR(10),
        email VARCHAR(30)
    )";
    $coDB->exec($sql);
    echo "Table 'adherent' créée.\n";

} catch (PDOException $e) {
    die("Erreur table adherent: " . $e->getMessage());
}