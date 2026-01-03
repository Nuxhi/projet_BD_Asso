<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Ajouter une section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-3xl mx-auto px-6 py-12">
        
        <!-- Bouton retour -->
        <a href="/section-liste" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Retour à la liste des sections
        </a>

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                <i class="fa-solid fa-plus text-indigo-600 mr-3"></i>
                Ajouter une section
            </h1>
            <p class="mt-2 text-slate-600">Créez une nouvelle section pour l'association ASCG.</p>
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
            <form method="POST" action="/section-ajouter" class="p-8 space-y-6">
                
                <!-- Code et Nom de la section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="cd_section" class="block text-sm font-bold text-slate-700 mb-2">
                            Code section <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="cd_section" name="cd_section" 
                               value="<?php echo htmlspecialchars($formData['cd_section']); ?>"
                               maxlength="5"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors uppercase"
                               placeholder="Ex: SPR" required>
                        <p class="mt-1 text-xs text-slate-400">Maximum 5 caractères</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="lib_section" class="block text-sm font-bold text-slate-700 mb-2">
                            Nom de la section <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lib_section" name="lib_section" 
                               value="<?php echo htmlspecialchars($formData['lib_section']); ?>"
                               maxlength="30"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               placeholder="Ex: Section Sport" required>
                        <p class="mt-1 text-xs text-slate-400">Maximum 30 caractères</p>
                    </div>
                </div>

                <!-- Dates de saison -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_deb_saison" class="block text-sm font-bold text-slate-700 mb-2">
                            Date de début de saison <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_deb_saison" name="date_deb_saison" 
                               value="<?php echo htmlspecialchars($formData['date_deb_saison']); ?>"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                    </div>
                    
                    <div>
                        <label for="date_fin_saison" class="block text-sm font-bold text-slate-700 mb-2">
                            Date de fin de saison <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="date_fin_saison" name="date_fin_saison" 
                               value="<?php echo htmlspecialchars($formData['date_fin_saison']); ?>"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                    </div>
                </div>

                <!-- Référent -->
                <div>
                    <label for="id_ben_referent" class="block text-sm font-bold text-slate-700 mb-2">
                        Référent de la section <span class="text-red-500">*</span>
                    </label>
                    <select id="id_ben_referent" name="id_ben_referent" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Sélectionner un référent --</option>
                        <?php foreach ($benevoles as $benevole): ?>
                            <option value="<?php echo $benevole['id_ben']; ?>"
                                    <?php echo $formData['id_ben_referent'] == $benevole['id_ben'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($benevole['pnom_ben'] . ' ' . $benevole['nom_ben']); ?>
                                (<?php echo htmlspecialchars($benevole['email_ben']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="mt-1 text-xs text-slate-400">Le référent sera automatiquement ajouté à la section</p>
                </div>

                <!-- Note d'information -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-blue-700 text-sm">
                    <i class="fa-solid fa-info-circle mr-2"></i>
                    <strong>Note :</strong> Chaque section doit avoir un référent unique. Le référent sera automatiquement ajouté comme bénévole de la section avec le rôle "Référent".
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-slate-200">
                    <a href="/section-liste" 
                       class="px-6 py-3 text-slate-600 hover:text-slate-800 font-medium transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Créer la section
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
