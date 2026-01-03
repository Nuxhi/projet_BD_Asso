<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Liste des Sections</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-7xl mx-auto px-6 py-12">

        <!-- En-tête -->
        <div class="mb-12 pb-6 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                    Sections de l'Association
                </h1>
                <p class="mt-2 text-lg text-slate-600">Gérez les sections sportives et culturelles de l'ASCG.</p>
            </div>
            <a href="/section-ajouter" 
               class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                <i class="fa-solid fa-plus mr-2"></i>
                Nouvelle section
            </a>
        </div>
        <hr class="mb-8">

        <!-- Liste des sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php if (empty($sections)): ?>
                <div class="col-span-full text-center py-20">
                    <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-folder-open text-slate-400 text-4xl"></i>
                    </div>
                    <p class="text-gray-500 text-xl italic">Aucune section n'est enregistrée.</p>
                    <a href="/section-ajouter" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800">
                        <i class="fa-solid fa-plus mr-1"></i> Créer une section
                    </a>
                </div>
            <?php else: ?>
                
                <?php foreach ($sections as $section): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        
                        <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full <?php echo $section['cd_section'] === 'SPR' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'; ?>">
                                <?php echo htmlspecialchars($section['cd_section']); ?>
                            </span>
                            <span class="text-xs text-slate-400">
                                Saison <?php echo date('Y', strtotime($section['date_deb_saison'])); ?>-<?php echo date('Y', strtotime($section['date_fin_saison'])); ?>
                            </span>
                        </div>

                        <div class="p-6">
                            <h2 class="text-xl font-bold text-slate-800 mb-3">
                                <?php echo htmlspecialchars($section['lib_section']); ?>
                            </h2>
                            
                            <div class="space-y-3 mb-6">
                                <!-- Référent -->
                                <div class="flex items-center text-slate-600">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center mr-3">
                                        <i class="fa-solid fa-user-tie text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Référent</p>
                                        <p class="font-medium"><?php echo htmlspecialchars($section['pnom_ben'] . ' ' . $section['nom_ben']); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Période -->
                                <div class="flex items-center text-slate-600">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center mr-3">
                                        <i class="fa-regular fa-calendar text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Période</p>
                                        <p class="font-medium">
                                            <?php echo date('d/m/Y', strtotime($section['date_deb_saison'])); ?> - 
                                            <?php echo date('d/m/Y', strtotime($section['date_fin_saison'])); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <a href="/section-detail?cd=<?php echo urlencode($section['cd_section']); ?>" 
                               class="block w-full text-center px-4 py-2 bg-indigo-50 text-indigo-600 font-semibold rounded-xl hover:bg-indigo-100 transition-colors">
                                <i class="fa-solid fa-users mr-2"></i>
                                Voir les bénévoles
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>

</body>
</html>
