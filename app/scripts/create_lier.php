<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS lier (
        num_adherent_1 CHAR(5),
        num_adherent_2 CHAR(5),
        nature_rel VARCHAR(50),
        PRIMARY KEY (num_adherent_1, num_adherent_2),
        FOREIGN KEY (num_adherent_1) REFERENCES adherent(num_adherent),
        FOREIGN KEY (num_adherent_2) REFERENCES adherent(num_adherent)
    )";
    $coDB->exec($sql);
    echo "Table 'lier' créée.\n";

} catch (PDOException $e) { 
    die("Erreur table lier: " . $e->getMessage());
}