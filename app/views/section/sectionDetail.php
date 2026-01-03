<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Section - <?php echo htmlspecialchars($section['lib_section']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">

    <?php include __DIR__ . '/../partial/navbar.php'; ?>

    <div class="max-w-5xl mx-auto px-6 py-12">
        
        <a href="/section-liste" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Retour à la liste des sections
        </a>

        <!-- Message de notification -->
        <?php if (!empty($message)): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $messageType === 'success' ? 'bg-emerald-50 border border-emerald-200 text-emerald-700' : 'bg-red-50 border border-red-200 text-red-700'; ?>">
                <div class="flex items-center">
                    <i class="fa-solid <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-3 text-xl"></i>
                    <span><?php echo $message; ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- En-tête de la section -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-200 flex justify-between items-center">
                <span class="px-4 py-2 text-sm font-bold uppercase tracking-wider rounded-full <?php echo $section['cd_section'] === 'SPR' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700'; ?>">
                    <?php echo htmlspecialchars($section['cd_section']); ?>
                </span>
                <span class="text-sm text-slate-500">
                    Saison <?php echo date('Y', strtotime($section['date_deb_saison'])); ?>-<?php echo date('Y', strtotime($section['date_fin_saison'])); ?>
                </span>
            </div>

            <div class="p-8">
                <h1 class="text-3xl font-bold text-slate-800 mb-6">
                    <?php echo htmlspecialchars($section['lib_section']); ?>
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Référent -->
                    <div class="flex items-center p-4 bg-indigo-50 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
                            <i class="fa-solid fa-user-tie text-indigo-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-500 uppercase font-bold">Référent de la section</p>
                            <p class="text-lg font-semibold text-slate-800">
                                <?php echo htmlspecialchars($section['pnom_ben'] . ' ' . $section['nom_ben']); ?>
                            </p>
                            <p class="text-sm text-slate-500"><?php echo htmlspecialchars($section['email_ben']); ?></p>
                        </div>
                    </div>
                    
                    <!-- Période -->
                    <div class="flex items-center p-4 bg-emerald-50 rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center mr-4">
                            <i class="fa-regular fa-calendar text-emerald-600 text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-emerald-500 uppercase font-bold">Période de la saison</p>
                            <p class="text-lg font-semibold text-slate-800">
                                <?php echo date('d/m/Y', strtotime($section['date_deb_saison'])); ?>
                            </p>
                            <p class="text-sm text-slate-500">au <?php echo date('d/m/Y', strtotime($section['date_fin_saison'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-200 flex justify-between items-center">
                <h2 class="text-xl font-bold text-slate-800">
                    <i class="fa-solid fa-users mr-2 text-indigo-600"></i>
                    Bénévoles de la section
                </h2>
                <span class="px-3 py-1  bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">
                    <?php echo count($benevoles); ?> bénévole(s)
                </span>
            </div>

            <?php if (empty($benevoles)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-user-slash text-slate-400 text-3xl"></i>
                    </div>
                    <p class="text-slate-500 text-lg">Aucun bénévole dans cette section</p>
                    <p class="text-slate-400 text-sm mt-1">Ajoutez des bénévoles via le formulaire ci-dessous</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Bénévole</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Fonction</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($benevoles as $benevole): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full <?php echo $benevole['is_referent'] ? 'bg-indigo-100' : 'bg-slate-100'; ?> flex items-center justify-center mr-3">
                                                <span class="<?php echo $benevole['is_referent'] ? 'text-indigo-600' : 'text-slate-600'; ?> font-bold text-sm">
                                                    <?php echo strtoupper(substr($benevole['pnom_ben'], 0, 1) . substr($benevole['nom_ben'], 0, 1)); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    <?php echo htmlspecialchars($benevole['pnom_ben'] . ' ' . $benevole['nom_ben']); ?>
                                                    <?php if ($benevole['is_referent']): ?>
                                                        <span class="ml-2 px-2 py-0.5 text-xs bg-indigo-100 text-indigo-700 rounded-full font-bold">
                                                            <i class="fa-solid fa-star text-xs mr-1"></i>Référent
                                                        </span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="text-xs text-slate-400">ID: <?php echo $benevole['id_ben']; ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-600 text-sm"><?php echo htmlspecialchars($benevole['email_ben']); ?></p>
                                        <p class="text-slate-400 text-xs"><?php echo htmlspecialchars($benevole['tel_ben']); ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-sm font-medium bg-slate-100 text-slate-700 rounded-full">
                                            <?php echo htmlspecialchars($benevole['role']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" 
                                                onclick="openEditModal(<?php echo $benevole['id_ben']; ?>, '<?php echo htmlspecialchars(addslashes($benevole['pnom_ben'] . ' ' . $benevole['nom_ben'])); ?>', '<?php echo htmlspecialchars(addslashes($benevole['role'])); ?>')"
                                                class="px-3 py-1 text-sm text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <i class="fa-solid fa-pen mr-1"></i>
                                            Modifier
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulaire d'ajout de bénévole -->
        <?php if (!empty($benevolesDisponibles)): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-200">
                    <h2 class="text-xl font-bold text-slate-800">
                        <i class="fa-solid fa-user-plus mr-2 text-emerald-600"></i>
                        Ajouter un bénévole à la section
                    </h2>
                </div>
                
                <form method="POST" action="/section-detail?cd=<?php echo urlencode($section['cd_section']); ?>" class="p-8">
                    <input type="hidden" name="action" value="add_benevole">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="id_ben" class="block text-sm font-bold text-slate-700 mb-2">
                                Bénévole <span class="text-red-500">*</span>
                            </label>
                            <select id="id_ben" name="id_ben" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($benevolesDisponibles as $ben): ?>
                                    <option value="<?php echo $ben['id_ben']; ?>">
                                        <?php echo htmlspecialchars($ben['pnom_ben'] . ' ' . $ben['nom_ben']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label for="role" class="block text-sm font-bold text-slate-700 mb-2">
                                Fonction <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="role" name="role" 
                                   maxlength="30"
                                   class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                   placeholder="Ex: Trésorier, Secrétaire..." required>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Ajouter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-amber-700">
                <i class="fa-solid fa-info-circle mr-2"></i>
                Tous les bénévoles sont déjà rattachés à cette section.
            </div>
        <?php endif; ?>

    </div>

    <!-- Modal de modification de fonction -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Modifier la fonction</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <form method="POST" action="/section-detail?cd=<?php echo urlencode($section['cd_section']); ?>">
                <input type="hidden" name="action" value="update_role">
                <input type="hidden" name="id_ben" id="edit_id_ben">
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Bénévole</label>
                        <p id="edit_benevole_name" class="text-slate-600"></p>
                    </div>
                    
                    <div>
                        <label for="edit_role" class="block text-sm font-bold text-slate-700 mb-2">
                            Nouvelle fonction <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="edit_role" name="role" 
                               maxlength="30"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                               required>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-slate-600 hover:text-slate-800 font-medium">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(idBen, nomComplet, roleActuel) {
            document.getElementById('edit_id_ben').value = idBen;
            document.getElementById('edit_benevole_name').textContent = nomComplet;
            document.getElementById('edit_role').value = roleActuel;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
        
        // Fermer la modal en cliquant à l'extérieur
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>

</body>
</html>
