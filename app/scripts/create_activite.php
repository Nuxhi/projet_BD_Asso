<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS activite (
        id_activ INTEGER PRIMARY KEY,
        lib_activ VARCHAR(30),
        desc_activ VARCHAR(150),
        jour VARCHAR(8),
        h_deb CHAR(5),
        duree_min INTEGER,
        tarif FLOAT,
        cd_section_activ CHAR(5) NOT NULL,
        id_lieu_activ INTEGER,
        FOREIGN KEY (cd_section_activ) REFERENCES section(cd_section),
        FOREIGN KEY (id_lieu_activ) REFERENCES lieu(id_lieu)
    )";
    $coDB->exec($sql);
    echo "Table 'activite' créée.\n";

} catch (PDOException $e) { 
    die("Erreur table activite: " . $e->getMessage());
}