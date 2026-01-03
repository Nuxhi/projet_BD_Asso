<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS appartenir (
        id_ben INTEGER,
        cd_section CHAR(5),
        role VARCHAR(30),
        PRIMARY KEY (id_ben, cd_section),
        FOREIGN KEY (id_ben) REFERENCES benevole(id_ben),
        FOREIGN KEY (cd_section) REFERENCES section(cd_section)
    )";
    $coDB->exec($sql);
    echo "Table 'appartenir' créée.\n";
    
} catch (PDOException $e) {
    die("Erreur table appartenir: " . $e->getMessage());
}