<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS section (
        cd_section CHAR(5) PRIMARY KEY,
        lib_section VARCHAR(30),
        date_deb_saison DATE,
        date_fin_saison DATE,
        id_ben_referent INTEGER NOT NULL,
        FOREIGN KEY (id_ben_referent) REFERENCES benevole(id_ben)
    )";
    $coDB->exec($sql);
    echo "Table 'section' créée.\n";

} catch (PDOException $e) {
    die("Erreur table section: " . $e->getMessage());
}