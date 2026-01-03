<?php

require_once __DIR__ . '/../../config/database.php';

try {
    $db = new Database();
    $coDB = $db->connect();

    //voir https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site/issues/227
    $coDB->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = ['inscrire', 'activite', 'lier', 'adherent', 'appartenir', 'section', 'lieu', 'benevole'];
    foreach ($tables as $table) {
        $coDB->exec("DROP TABLE IF EXISTS $table");
    }
    echo "Anciennes tables supprimées.\n";

    include_once __DIR__ .'/create_benevole.php';
    include_once __DIR__ .'/create_lieu.php';
    include_once __DIR__ .'/create_section.php';
    include_once __DIR__ .'/create_appartenir.php';
    include_once __DIR__ .'/create_adherent.php';
    include_once __DIR__ .'/create_lier.php';
    include_once __DIR__ .'/create_activite.php';
    include_once __DIR__ .'/create_inscrire.php';

    $coDB->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "bdd cree avec succes";

} catch (Exception $e) {
    echo 'Une erreur est survenue : '. $e->getMessage() .'';
}
