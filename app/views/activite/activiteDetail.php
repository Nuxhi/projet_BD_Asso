<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Détail de l'activité - <?php echo htmlspecialchars($activite['lib_activ']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-5xl mx-auto px-6 py-12">
        
        <!-- Bouton retour -->
        <a href="/activite-liste" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Retour à la liste des activités
        </a>

        <!-- En-tête de l'activité -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-200 flex justify-between items-center">
                <span class="px-4 py-2 text-sm font-bold uppercase tracking-wider rounded-full <?php echo $activite['cd_section'] === 'SPR' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'; ?>">
                    <?php echo htmlspecialchars($activite['lib_section']); ?>
                </span>
                <span class="text-sm font-medium text-slate-500 italic">
                    Ref: #<?php echo $activite['id_activ']; ?>
                </span>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-slate-800 mb-4 capitalize">
                    <?php echo htmlspecialchars($activite['lib_activ']); ?>
                </h1>
                
                <p class="text-slate-600 mb-8 text-base leading-relaxed">
                    <?php echo htmlspecialchars($activite['desc_activ']); ?>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Jour et heure -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center mr-4">
                            <i class="fa-regular fa-calendar-check text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Horaire</p>
                            <p class="text-slate-800 font-medium"><?php echo $activite['jour']; ?> à <?php echo $activite['h_deb']; ?></p>
                        </div>
                    </div>
                    
                    <!-- Durée -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center mr-4">
                            <i class="fa-regular fa-clock text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Durée</p>
                            <p class="text-slate-800 font-medium"><?php echo $activite['duree_min']; ?> minutes</p>
                        </div>
                    </div>
                    
                    <!-- Lieu -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center mr-4">
                            <i class="fa-solid fa-location-dot text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Lieu</p>
                            <p class="text-slate-800 font-medium"><?php echo htmlspecialchars($activite['lib_lieu']); ?></p>
                        </div>
                    </div>
                    
                    <!-- Tarif -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center mr-4">
                            <i class="fa-solid fa-euro-sign text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold">Tarif annuel</p>
                            <p class="text-slate-800 font-bold text-lg"><?php echo number_format($activite['tarif'], 2, ',', ' '); ?> €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations sur les places -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Nombre d'inscrits -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Inscrits</p>
                        <p class="text-3xl font-bold text-slate-800"><?php echo $nbInscrits; ?></p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                        <i class="fa-solid fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Capacité -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Capacité max</p>
                        <p class="text-3xl font-bold text-slate-800"><?php echo $activite['capacite']; ?></p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-building text-slate-600 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Places restantes -->
            <div class="bg-white rounded-xl shadow-sm border <?php echo $estComplete ? 'border-red-200' : 'border-emerald-200'; ?> p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm <?php echo $estComplete ? 'text-red-500' : 'text-emerald-500'; ?> font-medium">
                            Places restantes
                        </p>
                        <p class="text-3xl font-bold <?php echo $estComplete ? 'text-red-600' : 'text-emerald-600'; ?>">
                            <?php echo max(0, $placesRestantes); ?>
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-full <?php echo $estComplete ? 'bg-red-50' : 'bg-emerald-50'; ?> flex items-center justify-center">
                        <i class="fa-solid <?php echo $estComplete ? 'fa-xmark' : 'fa-check'; ?> <?php echo $estComplete ? 'text-red-600' : 'text-emerald-600'; ?> text-2xl"></i>
                    </div>
                </div>
                <?php if ($estComplete): ?>
                    <p class="mt-3 text-sm text-red-600 font-semibold bg-red-50 px-3 py-2 rounded-lg text-center">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                        Activité complète
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Liste des inscrits -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-800">
                    <i class="fa-solid fa-list-check mr-2 text-indigo-600"></i>
                    Liste des membres inscrits
                </h2>
            </div>

            <?php if (empty($inscrits)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-user-slash text-slate-400 text-3xl"></i>
                    </div>
                    <p class="text-slate-500 text-lg">Aucun inscrit pour le moment</p>
                    <p class="text-slate-400 text-sm mt-1">Les adhérents inscrits apparaîtront ici</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Adhérent</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Téléphone</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Date d'inscription</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Remise</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($inscrits as $inscrit): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                                <span class="text-indigo-600 font-bold text-sm">
                                                    <?php echo strtoupper(substr($inscrit['pnom_adherent'], 0, 1) . substr($inscrit['nom_adherent'], 0, 1)); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    <?php echo htmlspecialchars($inscrit['pnom_adherent'] . ' ' . $inscrit['nom_adherent']); ?>
                                                </p>
                                                <p class="text-xs text-slate-400">N° <?php echo htmlspecialchars($inscrit['num_adherent']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <?php echo htmlspecialchars($inscrit['email']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <?php echo htmlspecialchars($inscrit['tel']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <?php echo date('d/m/Y', strtotime($inscrit['date_insc'])); ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php if ($inscrit['remise'] > 0): ?>
                                            <span class="px-3 py-1 text-sm font-medium bg-emerald-100 text-emerald-700 rounded-full">
                                                -<?php echo $inscrit['remise']; ?>%
                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-400">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
