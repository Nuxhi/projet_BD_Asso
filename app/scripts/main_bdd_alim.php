<?php

require_once __DIR__ . '/../../config/database.php';

try {
    $db = new Database();
    $coDB = $db->connect();

    //voir https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site/issues/227
    $coDB->exec("SET FOREIGN_KEY_CHECKS = 0"); 
    
    // TRUNCATE remet l'id auto à 1, pas DELETE
    $coDB->exec('TRUNCATE TABLE ACTIVITE');
    $coDB->exec('TRUNCATE TABLE ADHERENT');
    $coDB->exec('TRUNCATE TABLE APPARTENIR');
    $coDB->exec('TRUNCATE TABLE BENEVOLE');
    $coDB->exec('TRUNCATE TABLE INSCRIRE');
    $coDB->exec('TRUNCATE TABLE LIER');
    $coDB->exec('TRUNCATE TABLE LIEU');
    $coDB->exec('TRUNCATE TABLE SECTION');

    echo "données effacées \n";

    $benevoles = [
        [1, 'Lemoine', 'Thomas', '0612345678', 't.lemoine@email.fr'],
        [2, 'Gauthier', 'Sandrine', '0789456123', 's.gauthier@email.fr'],
        [3, 'Rousseau', 'Julien', '0655494545', 'j.rousseau@email.fr']
    ];
    $sql = "INSERT INTO benevole (id_ben, nom_ben, pnom_ben, tel_ben, email_ben) VALUES (?, ?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($benevoles as $b) $stmt->execute($b);
    echo "Bénévoles insérés.\n";


    $lieux = [
        [1, 'Gymnase Municipal', '12 rue des Sports', 100],
        [2, 'Salle des Fêtes', '5 Place de la Mairie', 50]
    ];
    $sql = "INSERT INTO lieu (id_lieu, lib_lieu, ad_lieu, capacite) VALUES (?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($lieux as $l) $stmt->execute($l);
    echo "Lieux insérés.\n";

    $sections = [
        ['SPR', 'Section Sport', '2025-09-01', '2026-06-30', 1],
        ['MSQ', 'Section Musique', '2025-09-01', '2026-06-30', 3]
    ];
    $sql = "INSERT INTO section (cd_section, lib_section, date_deb_saison, date_fin_saison, id_ben_referent) VALUES (?, ?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($sections as $s) $stmt->execute($s);
    echo "Sections insérées.\n";

    $activites = [
        [101, 'Entraînement U15', 'Basket pour les moins de 15 ans', 'Mercredi', '14:30', 90, 150.00, 'SPR', 1],
        [102, 'Batterie', 'Batterie niveau débutant', 'Lundi', '18:00', 60, 200.00, 'MSQ', 2],
        [103, 'Batterie', 'Batterie niveau confirmé', 'Samedi', '10:00', 45, 120.00, 'MSQ', 2]
    ];
    $sql = "INSERT INTO activite (id_activ, lib_activ, desc_activ, jour, h_deb, duree_min, tarif, cd_section_activ, id_lieu_activ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($activites as $act) $stmt->execute($act);
    echo "Activités insérées.\n";

    $adherents = [
        ['01012', 'Martin', 'Alice', '1995-05-12', '3 rue de la Paix', '75001', 'Paris', '0102030405', 'alice.martin@gmail.com'],
        ['01021', 'Durand', 'Lucas', '2010-08-20', '45 avenue des Lilas', '69000', 'Lyon', '0405060708', 'l.durand@gmail.com'],
        ['44544', 'Bernard', 'Chloé', '1988-11-03', '12 impasse du Sud', '31000', 'Toulouse', '0506070809', 'chloe.b@gmail.com']
    ];
    $sql = "INSERT INTO adherent (num_adherent, nom_adherent, pnom_adherent, date_nais, ad_adherent, cp_adherent, ville_adherent, tel, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($adherents as $adh) $stmt->execute($adh);
    echo "Adhérents insérés.\n";

    $appartenir = [
        [1, 'SPR', 'Gérant'],
        [2, 'MSQ', 'Trésorière'],
        [3, 'MSQ', "Chef d'orchestre"]
    ];
    $sql = "INSERT INTO appartenir (id_ben, cd_section, role) VALUES (?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($appartenir as $app) $stmt->execute($app);
    echo "Liaisons Bénévoles-Sections insérées.\n";

    $inscriptions = [
        [101, '01021', 0, '2025-09-05'],
        [102, '01012', 0, '2025-09-10'],
        [102, '44544', 10, '2025-09-12'],
        [103, '01021', 5, '2025-09-15']
    ];
    $sql = "INSERT INTO inscrire (id_activ, num_adherent, remise, date_insc) VALUES (?, ?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($inscriptions as $i) $stmt->execute($i);
    echo "Inscriptions insérées.\n";

    $liens = [
        ['01012', '01021', 'Frère-Sœur'],
        ['44544', '01012', 'Mère-fille']
    ];
    $sql = "INSERT INTO lier (num_adherent_1, num_adherent_2, nature_rel) VALUES (?, ?, ?)";
    $stmt = $coDB->prepare($sql);
    foreach ($liens as $l) $stmt->execute($l);
    echo "Relations adhérents insérées, insertion terminée.\n";

    $coDB->exec("SET FOREIGN_KEY_CHECKS = 1");


} catch (Exception $e) {
    echo 'Une erreur est survenue : '. $e->getMessage() .'';
}