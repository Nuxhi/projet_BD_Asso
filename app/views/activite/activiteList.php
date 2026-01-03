<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Planning des Activités - ASCG</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-12">

             
        <div class="mb-12 pb-6 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                    Planning des Activités
                </h1>
                <p class="mt-2 text-lg text-slate-600">Découvrez nos activités pour la saison 2025-2026.</p>
            </div>
            <a href="/activite-ajouter" 
               class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                <i class="fa-solid fa-plus mr-2"></i>
                Nouvelle activité
            </a>
        </div>
        <hr class="mb-8">

        <!-- Filtres avec formulaire pour requêtes côté serveur -->
        <form method="GET" action="/activite-liste" id="filtreForm" class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-slate-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                
                <!-- Jours -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jours</label>
                    <div class="flex flex-wrap gap-2" id="filtre_jour">
                        <?php 
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']; 
                        $joursSelectionnes = isset($_GET['jours']) ? $_GET['jours'] : [];
                        foreach($jours as $j): ?>
                            <label class="flex items-center space-x-2 bg-slate-50 px-2 py-1 rounded border cursor-pointer hover:bg-slate-100">
                                <input type="checkbox" name="jours[]" value="<?php echo $j; ?>" 
                                       class="filtre_jour text-indigo-600"
                                       <?php echo in_array($j, $joursSelectionnes) ? 'checked' : ''; ?>>
                                <span class="text-xs"><?php echo $j; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Horaire -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Horaires (Entre)</label>
                    <div class="flex items-center space-x-2">
                        <input type="time" name="heure_min" id="tps_min" 
                               class="filtre-input border rounded px-2 py-1 text-sm w-full" 
                               value="<?php echo isset($_GET['heure_min']) ? htmlspecialchars($_GET['heure_min']) : ''; ?>"
                               placeholder="08:00">
                        <span>et</span>
                        <input type="time" name="heure_max" id="tps_max" 
                               class="filtre-input border rounded px-2 py-1 text-sm w-full" 
                               value="<?php echo isset($_GET['heure_max']) ? htmlspecialchars($_GET['heure_max']) : ''; ?>"
                               placeholder="22:00">
                    </div>
                </div>

                <!-- Sections -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Sections</label>
                    <div class="max-h-24 overflow-y-auto border rounded p-2 text-sm" id="filtre_section">
                        <?php 
                        $sectionsSelectionnees = isset($_GET['sections']) ? $_GET['sections'] : [];
                        foreach($sections as $sec): ?>
                            <label class="flex items-center space-x-2 mb-1">
                                <input type="checkbox" name="sections[]" 
                                       value="<?php echo htmlspecialchars($sec['lib_section']); ?>" 
                                       class="filtre_section"
                                       <?php echo in_array($sec['lib_section'], $sectionsSelectionnees) ? 'checked' : ''; ?>>
                                <span><?php echo htmlspecialchars($sec['lib_section']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Boutons de filtre -->
                <div class="flex flex-col justify-end space-y-2">
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fa-solid fa-filter mr-2"></i>
                        Filtrer
                    </button>
                    <a href="/activite-liste" 
                       class="w-full px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-lg hover:bg-slate-200 transition-colors text-center">
                        <i class="fa-solid fa-xmark mr-2"></i>
                        Réinitialiser
                    </a>
                </div>
            </div>
        </form>

        <!-- Indicateur de filtres actifs -->
        <?php 
        $hasFilters = !empty($_GET['jours']) || !empty($_GET['sections']) || !empty($_GET['heure_min']) || !empty($_GET['heure_max']);
        if ($hasFilters): 
        ?>
            <div class="mb-6 p-3 bg-indigo-50 border border-indigo-200 rounded-lg text-indigo-700 text-sm">
                <i class="fa-solid fa-filter mr-2"></i>
                Filtres actifs : 
                <?php 
                $filtresActifs = [];
                if (!empty($_GET['jours'])) $filtresActifs[] = count($_GET['jours']) . ' jour(s)';
                if (!empty($_GET['sections'])) $filtresActifs[] = count($_GET['sections']) . ' section(s)';
                if (!empty($_GET['heure_min'])) $filtresActifs[] = 'à partir de ' . htmlspecialchars($_GET['heure_min']);
                if (!empty($_GET['heure_max'])) $filtresActifs[] = 'jusqu\'à ' . htmlspecialchars($_GET['heure_max']);
                echo implode(' | ', $filtresActifs);
                ?>
                - <strong><?php echo count($activites); ?> résultat(s)</strong>
            </div>
        <?php endif; ?>

        <div id="activites" class="flex flex-wrap -mx-4">  
            
            <?php if (empty($activites)): ?>
                <div class="w-full px-4 text-center py-20">
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-calendar-xmark text-slate-400 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 text-xl italic">Aucune activité ne correspond à vos critères.</p>
                    <a href="/activite-liste" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Voir toutes les activités
                    </a>
                </div>
            <?php else: ?>
                
                <?php foreach ($activites as $act): ?>
                    <div class="activite w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                        
                        <div class="flex flex-col h-full bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            
                            <div class="px-6 py-4 flex justify-between items-center bg-slate-50/50">
                                <span class="lib_section px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full <?php echo $act['cd_section'] === 'SPR' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'; ?>">
                                    <?php echo htmlspecialchars($act['lib_section']); ?>
                                </span>
                                <span class="text-sm font-medium text-slate-500 italic">
                                    Ref: #<?php echo $act['id_activ']; ?>
                                </span>
                            </div>

                            <div class="p-6 flex-grow">
                                <h2 class="text-2xl font-bold text-slate-800 mb-3 capitalize">
                                    <?php echo htmlspecialchars($act['lib_activ']); ?>
                                </h2>
                                <p class="text-slate-600 mb-6 text-sm leading-relaxed">
                                    <?php echo htmlspecialchars($act['desc_activ']); ?>
                                </p>

                                <div class="space-y-3">
                                    <div class="flex items-center text-slate-700">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center mr-3">
                                            <i class="fa-regular fa-calendar-check text-indigo-600"></i>
                                        </div>
                                        <span class="font-medium">
                                            <span class="jour"><?= $act['jour'] ?></span> à 
                                            <span class="heure"><?= $act['h_deb'] ?></span>
                                        </span>
                                    </div>

                                    <div class="flex items-center text-slate-700">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center mr-3">
                                            <i class="fa-solid fa-location-dot text-emerald-600"></i>
                                        </div>
                                        <span><?php echo htmlspecialchars($act['lib_lieu']); ?></span>
                                    </div>
                                    
                                    <div class="flex items-center text-slate-700">
                                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center mr-3">
                                            <i class="fa-regular fa-clock text-amber-600"></i>
                                        </div>
                                        <span>Durée : <?php echo $act['duree_min']; ?> min</span>
                                    </div>

                                    <!-- Affichage du nombre de places -->
                                    <div class="flex items-center text-slate-700">
                                        <div class="w-8 h-8 rounded-lg <?php echo $act['est_complete'] ? 'bg-red-50' : 'bg-blue-50'; ?> flex items-center justify-center mr-3">
                                            <i class="fa-solid fa-users <?php echo $act['est_complete'] ? 'text-red-600' : 'text-blue-600'; ?>"></i>
                                        </div>
                                        <span class="<?php echo $act['est_complete'] ? 'text-red-600 font-semibold' : ''; ?>">
                                            <?php echo $act['nb_inscrits']; ?>/<?php echo $act['capacite']; ?> inscrits
                                            <?php if ($act['est_complete']): ?>
                                                <span class="ml-1 px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">Complet</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 mt-auto border-t border-slate-100">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="text-xs text-slate-400 uppercase font-bold">Tarif Annuel</p>
                                        <p class="prix text-2xl font-black text-slate-900"><?php echo number_format($act['tarif'], 2, ',', ' '); ?> €</p>
                                    </div>
                                    <?php if (!$act['est_complete']): ?>
                                        <span class="px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full">
                                            <?php echo $act['places_restantes']; ?> place(s) restante(s)
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Bouton pour voir le détail -->
                                <a href="/activite-detail?id=<?php echo $act['id_activ']; ?>" 
                                   class="block w-full text-center px-4 py-2 bg-indigo-50 text-indigo-600 font-semibold rounded-xl hover:bg-indigo-100 transition-colors">
                                    <i class="fa-solid fa-eye mr-2"></i>
                                    Voir le détail
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>

</body>
</html>