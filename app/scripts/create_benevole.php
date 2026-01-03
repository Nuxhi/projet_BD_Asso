<?php
try {
    $sql = "CREATE TABLE IF NOT EXISTS benevole (
        id_ben INTEGER PRIMARY KEY,
        nom_ben VARCHAR(30),
        pnom_ben VARCHAR(30),
        tel_ben CHAR(10),
        email_ben VARCHAR(30)
    )";
    $coDB->exec($sql);
    echo "Table 'benevole' créée.\n";

} catch (PDOException $e) {
    die("Erreur table benevole: " . $e->getMessage());
}