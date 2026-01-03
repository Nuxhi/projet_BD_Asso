<?php

try {
    $sql = "CREATE TABLE IF NOT EXISTS lieu (
        id_lieu INTEGER PRIMARY KEY,
        lib_lieu VARCHAR(50),
        ad_lieu VARCHAR(50),
        capacite INTEGER
    )";
    $coDB->exec($sql);
    echo "Table 'lieu' créée.\n";
    
} catch (PDOException $e) {
    die("Erreur table lieu: " . $e->getMessage());
}