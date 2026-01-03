<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Ajouter une activité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-3xl mx-auto px-6 py-12">
        
        <!-- Bouton retour -->
        <a href="/activite-liste" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Retour à la liste des activités
        </a>

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                <i class="fa-solid fa-plus text-indigo-600 mr-3"></i>
                Ajouter une activité
            </h1>
            <p class="mt-2 text-slate-600">Créez une nouvelle activité pour l'association.</p>
        </div>

        <!-- Message de notification -->
        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $messageType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                <div class="flex items-center">
                    <i class="fa-solid <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-3 text-xl"></i>
                    <span><?php echo $message; ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <form method="POST" action="/activite-ajouter" class="p-8 space-y-6">
                
                <!-- Libellé -->
                <div>
                    <label for="lib_activ" class="block text-sm font-bold text-slate-700 mb-2">
                        Libellé de l'activité <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="lib_activ" name="lib_activ" 
                           value="<?php echo htmlspecialchars($formData['lib_activ']); ?>"
                           maxlength="30"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                           placeholder="Ex: Yoga débutant" required>
                    <p class="mt-1 text-xs text-slate-400">Maximum 30 caractères</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="desc_activ" class="block text-sm font-bold text-slate-700 mb-2">
                        Description
                    </label>
                    <textarea id="desc_activ" name="desc_activ" rows="3"
                              maxlength="150"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                              placeholder="Description de l'activité..."><?php echo htmlspecialchars($formData['desc_activ']); ?></textarea>
                    <p class="mt-1 text-xs text-slate-400">Maximum 150 caractères</p>
                </div>

                <!-- Section -->
                <div>
                    <label for="cd_section_activ" class="block text-sm font-bold text-slate-700 mb-2">
                        Section <span class="text-red-500">*</span>
                    </label>
                    <select id="cd_section_activ" name="cd_section_activ" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Sélectionner une section --</option>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?php echo htmlspecialchars($section['cd_section']); ?>"
                                    <?php echo $formData['cd_section_activ'] === $section['cd_section'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($section['lib_section']); ?> (<?php echo htmlspecialchars($section['cd_section']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Jour et Heure -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jour" class="block text-sm font-bold text-slate-700 mb-2">
                            Jour <span class="text-red-500">*</span>
                        </label>
                        <select id="jour" name="jour" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="">-- Sélectionner un jour --</option>
                            <?php foreach ($jours as $jour): ?>
                                <option value="<?php echo $jour; ?>"
                                        <?php echo $formData['jour'] === $jour ? 'selected' : ''; ?>>
                                    <?php echo $jour; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div>
                        <label for="h_deb" class="block text-sm font-bold text-slate-700 mb-2">
                            Heure de début <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="h_deb" name="h_deb" 
                               value="<?php echo htmlspecialchars($formData['h_deb']); ?>"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                    </div>
                </div>

                <!-- Durée et Tarif -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="duree_min" class="block text-sm font-bold text-slate-700 mb-2">
                            Durée (en minutes) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="duree_min" name="duree_min" 
                               value="<?php echo htmlspecialchars($formData['duree_min']); ?>"
                               min="1" max="480"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               placeholder="Ex: 60" required>
                        <p class="mt-1 text-xs text-slate-400">Entre 1 et 480 minutes</p>
                    </div>
                    
                    <div>
                        <label for="tarif" class="block text-sm font-bold text-slate-700 mb-2">
                            Tarif annuel (€) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="tarif" name="tarif" 
                               value="<?php echo htmlspecialchars($formData['tarif']); ?>"
                               min="0" step="0.01"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               placeholder="Ex: 150.00" required>
                    </div>
                </div>

                <!-- Lieu -->
                <div>
                    <label for="id_lieu_activ" class="block text-sm font-bold text-slate-700 mb-2">
                        Lieu / Salle <span class="text-red-500">*</span>
                    </label>
                    <select id="id_lieu_activ" name="id_lieu_activ" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Sélectionner un lieu --</option>
                        <?php foreach ($lieux as $lieu): ?>
                            <option value="<?php echo $lieu['id_lieu']; ?>"
                                    <?php echo $formData['id_lieu_activ'] == $lieu['id_lieu'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lieu['lib_lieu']); ?> - <?php echo htmlspecialchars($lieu['ad_lieu']); ?> (Capacité: <?php echo $lieu['capacite']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="/activite-liste" 
                       class="px-6 py-3 text-slate-600 hover:text-slate-800 font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Créer l'activité
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
