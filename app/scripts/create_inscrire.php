<?php
try {
    $sql = "CREATE TABLE IF NOT EXISTS inscrire (
        id_activ INTEGER,
        num_adherent CHAR(5),
        remise INTEGER,
        date_insc DATE,
        PRIMARY KEY (id_activ, num_adherent),
        FOREIGN KEY (id_activ) REFERENCES activite(id_activ),
        FOREIGN KEY (num_adherent) REFERENCES adherent(num_adherent)
    )";
    $coDB->exec($sql);
    echo "Table 'inscrire' créée.\n";
    
} catch (PDOException $e) {
    die("Erreur table inscrire: " . $e->getMessage());
}